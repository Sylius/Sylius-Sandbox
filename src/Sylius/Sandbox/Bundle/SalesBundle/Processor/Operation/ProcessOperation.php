<?php

namespace Sylius\Sandbox\Bundle\SalesBundle\Processor\Operation;

use Sylius\Bundle\SalesBundle\Model\OrderInterface;
use Sylius\Bundle\SalesBundle\Processor\Operation\ContainerAwareOperation;

class ProcessOperation extends ContainerAwareOperation
{
    public function prepare(OrderInterface $order)
    {
        $cart = $this->container->get('sylius_cart.provider')->getCart();

        if ($cart->isEmpty()) {
            throw new \LogicException('The cart must be not empty.');
        }

        $order->setUser($this->container->get('security.context')->getToken()->getUser());

        $orderItemManager = $this->container->get('sylius_sales.manager.item');

        foreach ($cart->getItems() as $item) {
            $orderItem = $orderItemManager->createItem();
            $orderItem->setVariant($item->getVariant());
            $orderItem->setQuantity($item->getQuantity());
            $orderItem->setUnitPrice($item->getVariant()->getPrice());

            $order->addItem($orderItem);
        }

        $order->calculateTotal();
    }

    public function process(OrderInterface $order)
    {
        // Abandon current cart.
        $this->container->get('sylius_cart.provider')->abandonCart();
    }

    public function finalize(OrderInterface $order)
    {
        $inventoryUnitManager = $this->container->get('sylius_inventory.manager.iu');
        $inventoryOperator = $this->container->get('sylius_inventory.operator');
        $variantManipulator = $this->container->get('sylius_assortment.manipulator.variant');

        foreach ($order->getItems() as $item) {
            $inventoryUnits = $inventoryOperator->decrease($item->getVariant(), $item->getQuantity());
            $order->addInventoryUnits($inventoryUnits);

            foreach ($inventoryUnits as $unit) {
                $inventoryUnitManager->persistInventoryUnit($unit);
            }

            $variantManipulator->update($item->getVariant());
        }
    }
}
