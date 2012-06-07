<?php

namespace Sylius\Sandbox\Bundle\SalesBundle\Processor\Operation;

use Sylius\Bundle\SalesBundle\Model\OrderInterface;
use Sylius\Bundle\SalesBundle\Processor\Operation\OperationInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class ProcessOperation extends ContainerAware implements OperationInterface
{
    public function prepare(OrderInterface $order)
    {
        $cart = $this->container->get('sylius_cart.provider')->getCart();

        if ($cart->isEmpty()) {
            throw new \LogicException('The cart must be not empty.');
        }
    }

    public function process(OrderInterface $order)
    {
        $cart = $this->container->get('sylius_cart.provider')->getCart();
        $orderItemManager = $this->container->get('sylius_sales.manager.item');
        $inventoryOperator = $this->container->get('sylius_inventory.operator');
        $variantManipulator = $this->container->get('sylius_assortment.manipulator.variant');

        foreach ($cart->getItems() as $item) {
            $orderItem = $orderItemManager->createItem();
            $orderItem->setVariant($item->getVariant());
            $orderItem->setQuantity($item->getQuantity());
            $orderItem->setUnitPrice($item->getVariant()->getPrice());

            $order->addItem($orderItem);

            $inventoryUnits = $inventoryOperator->decrease($item->getVariant(), $item->getQuantity());
            $order->addInventoryUnits($inventoryUnits);

            $variantManipulator->update($item->getVariant());
        }

        $order->calculateTotal();

        // Abandon current cart.
        $this->container->get('sylius_cart.provider')->abandonCart();
    }
}
