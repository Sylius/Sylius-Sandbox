<?php

namespace Sylius\Bundle\SandboxBundle\Process\Step;

use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Bundle\FlowBundle\Process\Context\ProcessContextInterface;
use Sylius\Bundle\FlowBundle\Process\Step\ControllerStep;

/**
 * The shipping step of checkout.
 * Based on the user address, we present the available shipping methods,
 * and ask him to select his preffered one.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class ShippingCheckoutStep extends ControllerStep
{
    /**
     * {@inheritdoc}
     */
    public function displayAction(ProcessContextInterface $context)
    {
        $form = $this->createCheckoutShippingForm($context);

        return $this->render('SyliusSandboxBundle:Frontend/Checkout/Step:shipping.html.twig', array(
            'form'    => $form->createView(),
            'context' => $context
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function forwardAction(ProcessContextInterface $context)
    {
        $request = $this->getRequest();
        $form = $this->createCheckoutShippingForm($context);

        if ($request->isMethod('POST') && $form->bindRequest($request)->isValid()) {
            $data = $form->getData();

            $shippingMethod = $data['method'];

            $context->getStorage()->set('shipping-method', $shippingMethod->getId());

            return $this->complete();
        }

        return $this->render('SyliusSandboxBundle:Frontend/Checkout/Step:shipping.html.twig', array(
            'form'    => $form->createView(),
            'context' => $context
        ));
    }

    private function createCheckoutShippingForm(ProcessContextInterface $context)
    {
        $deliveryAddress = $this->getAddress($context->getStorage()->get('delivery.address'));

        $zone = $this->get('sylius_addressing.zone_matcher')->match($deliveryAddress);

        return $this->createForm('sylius_sandbox_checkout_shipping', null, array(
            'shippables' => $this->getCurrentCart(),
            'criteria'   => array('zone' => $zone)
        ));
    }

    private function getCurrentCart()
    {
        return $this->get('sylius_cart.provider')->getCart();
    }

    private function getAddress($id)
    {
        $addressRepository = $this->container->get('sylius_addressing.repository.address');

        return $addressRepository->find($id);
    }
}
