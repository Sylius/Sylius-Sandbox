<?php

namespace Sylius\Sandbox\Bundle\SalesBundle\Process\Step;

use Sylius\Bundle\AddressingBundle\Model\AddressInterface;
use Sylius\Bundle\FlowBundle\Process\Context\ProcessContextInterface;
use Sylius\Bundle\FlowBundle\Process\Step\ContainerAwareStep;

/**
 * Billing step.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class BillingStep extends ContainerAwareStep
{
    /**
     * {@inheritdoc}
     */
    public function displayAction(ProcessContextInterface $context)
    {
        $address = $context->getStorage()->get('billing.address');
        $form = $this->createAddressForm($address);

        return $this->container->get('templating')->renderResponse('SyliusSalesBundle:Process/Checkout/Step:billing.html.twig', array(
            'form'    => $form->createView(),
            'context' => $context
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function forwardAction(ProcessContextInterface $context)
    {
        $request = $context->getRequest();
        $form = $this->createAddressForm();

        if ($request->isMethod('POST') && $form->bindRequest($request)->isValid()) {
            $context->getStorage()->set('billing.address', $form->getData());
            $context->complete();

            return;
        }

        return $this->container->get('templating')->renderResponse('SyliusSalesBundle:Process/Checkout/Step:billing.html.twig', array(
            'form'    => $form->createView(),
            'context' => $context
        ));
    }

    private function createAddressForm(AddressInterface $address = null)
    {
        return $this->container->get('form.factory')->create('sylius_addressing_address', $address);
    }
}
