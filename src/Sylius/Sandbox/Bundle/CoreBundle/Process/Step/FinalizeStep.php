<?php

namespace Sylius\Sandbox\Bundle\SalesBundle\Process\Step;

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

        return $this->container->get('templating')->renderResponse('SyliusSalesBundle:Process/Checkout/Step:finalize.html.twig', array(
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

        $eventDispatcher = $this->container->get('event_dispatcher');
        $processor = $this->container->get('sylius_sales.processor');

        $eventDispatcher->dispatch(SyliusSalesEvents::ORDER_PROCESS, new FilterOrderEvent($order));
        $processor->process($order);

        $eventDispatcher->dispatch(SyliusSalesEvents::ORDER_PLACE, new FilterOrderEvent($order));
        $this->container->get('sylius_sales.manipulator.order')->place($order);

        $eventDispatcher->dispatch(SyliusSalesEvents::ORDER_FINALIZE, new FilterOrderEvent($order));
        $processor->finalize($order);

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
        $order = $this->container->get('sylius_sales.manager.order')->createOrder();

        $deliveryAddress = $context->getStorage()->get('delivery.address');
        $billingAddress = $context->getStorage()->get('billing.address');

        $order->setDeliveryAddress($deliveryAddress);
        $order->setBillingAddress($billingAddress);

        $eventDispatcher = $this->container->get('event_dispatcher');
        $processor = $this->container->get('sylius_sales.processor');

        $eventDispatcher->dispatch(SyliusSalesEvents::ORDER_PREPARE, new FilterOrderEvent($order));
        $processor->prepare($order);

        return $order;
    }
}
