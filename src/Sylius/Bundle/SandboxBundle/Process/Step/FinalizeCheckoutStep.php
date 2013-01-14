<?php

namespace Sylius\Bundle\SandboxBundle\Process\Step;

use Sylius\Bundle\FlowBundle\Process\Context\ProcessContextInterface;
use Sylius\Bundle\FlowBundle\Process\Step\ControllerStep;
use Sylius\Bundle\SalesBundle\Model\OrderInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * Finalize checkout step.
 * It builds the order from cart.
 * Defines the shipment and method.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class FinalizeCheckoutStep extends ControllerStep
{
    /**
     * {@inheritdoc}
     */
    public function displayAction(ProcessContextInterface $context)
    {
        $order = $this->prepareOrder($context);

        return $this->render('SyliusSandboxBundle:Frontend/Checkout/Step:finalize.html.twig', array(
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

        $this->save($order);

        $this->container->get('session')->setFlash('success', 'Your order has been saved, thank you!');
        $this->container->get('sylius_cart.provider')->abandonCart();

        return $this->complete();
    }

    public function save(OrderInterface $order)
    {
        $manager = $this->container->get('sylius_sales.manager.order');

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

        $shippingMethod = $this->getShippingMethod($context->getStorage()->get('shipping-method'));

        $shipment = $this->createNewShipment();
        $shipment->setMethod($shippingMethod);

        foreach ($order->getInventoryUnits() as $item) {
            $shipment->addItem($item);
        }

        $order->addShipment($shipment);

        $order->setDeliveryAddress($deliveryAddress);
        $order->setBillingAddress($billingAddress);

        $orderBuilder = $this->container->get('sylius_sales.builder');
        $orderBuilder->build($order);

        $this->container->get('event_dispatcher')->dispatch('sylius_sales.order.pre_create', new GenericEvent($order));

        return $order;
    }

    private function getAddress($id)
    {
        $addressRepository = $this->container->get('sylius_addressing.repository.address');

        return $addressRepository->find($id);
    }

    private function getShippingMethod($id)
    {
        $shippingMethodRepository = $this->container->get('sylius_shipping.repository.method');

        return $shippingMethodRepository->find($id);
    }

    private function createNewShipment()
    {
        return $this->get('sylius_shipping.repository.shipment')->createNew();
    }
}
