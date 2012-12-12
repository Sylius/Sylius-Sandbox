<?php

namespace Sylius\Bundle\SandboxBundle\Process\Step;

use Sylius\Bundle\FlowBundle\Process\Context\ProcessContextInterface;
use Sylius\Bundle\FlowBundle\Process\Step\ContainerAwareStep;
use Sylius\Bundle\SalesBundle\Model\OrderInterface;

/**
 * Finalize step.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class FinalizeStep extends ContainerAwareStep
{
    /**
     * {@inheritdoc}
     */
    public function displayAction(ProcessContextInterface $context)
    {
        $order = $this->prepareOrder($context);

        return $this->container->get('templating')->renderResponse('SyliusSandboxBundle:Frontend/Checkout/Step:finalize.html.twig', array(
            'context' => $context,
            'order'   => $order
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function forwardAction(ProcessContextInterface $context)
    {
        $order = $this->prepareOrder($context);

        $this->container->get('sylius_sales.manager.order')->persist($order);
        $this->container->get('sylius_sales.manager.order')->persist($order);

        $orderBuilder = $this->container->get('sylius_sales.builder');
        $orderBuilder->finalize($order);

        $this->container->get('session')->setFlash('success', 'Your order has been saved, thank you!');

        return $this->complete();
    }

    public function save(OrderInterface $order)
    {
        $manager = $this->get('sylius_sales.manager.order');
        $manager->persist($order);
        $manager->flush();
    }

    /**
     * Prepare order.
     *
     * @param ProcessContextInterface $context
     *
     * @return OrderInterface
     */
    private function prepareOrder(ProcessContextInterface $context)
    {
        $order = $this->container->get('sylius_sales.repository.order')->createNew();

        $deliveryAddress = $this->getAddress($context->getStorage()->get('delivery.address'));
        $billingAddress = $this->getAddress($context->getStorage()->get('billing.address'));

        $order->setDeliveryAddress($deliveryAddress);
        $order->setBillingAddress($billingAddress);

        $orderBuilder = $this->container->get('sylius_sales.builder');
        $orderBuilder->build($order);

        return $order;
    }

    private function getAddress($id)
    {
        $addressRepository = $this->container->get('sylius_addressing.repository.address');

        return $addressRepository->find($id);
    }
}
