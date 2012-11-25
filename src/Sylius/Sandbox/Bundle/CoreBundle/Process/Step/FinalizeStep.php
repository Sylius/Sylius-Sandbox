<?php

namespace Sylius\Sandbox\Bundle\CoreBundle\Process\Step;

use Sylius\Bundle\FlowBundle\Process\Context\ProcessContextInterface;
use Sylius\Bundle\FlowBundle\Process\Step\ContainerAwareStep;
use Sylius\Bundle\SalesBundle\EventDispatcher\Event\FilterOrderEvent;
use Sylius\Bundle\SalesBundle\EventDispatcher\SyliusSalesEvents;

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

        return $this->container->get('templating')->renderResponse('SandboxCoreBundle:Process/Checkout/Step:finalize.html.twig', array(
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

        $orderBuilder = $this->container->get('sylius_sales.builder');
        $orderBuilder->finalize($order);

        $this->container->get('session')->setFlash('success', 'Your order has been saved, thank you!');

        $context->complete();
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
        $order = $this->container->get('sylius_sales.manager.order')->create();

        $deliveryAddress = $context->getStorage()->get('delivery.address');
        $billingAddress = $context->getStorage()->get('billing.address');

        $order->setDeliveryAddress($deliveryAddress);
        $order->setBillingAddress($billingAddress);

        $orderBuilder = $this->container->get('sylius_sales.builder');
        $orderBuilder->build($order);

        return $order;
    }
}
