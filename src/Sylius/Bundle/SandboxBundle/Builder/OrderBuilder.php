<?php

namespace Sylius\Bundle\SandboxBundle\Builder;

use Sylius\Bundle\SalesBundle\Builder\OrderBuilderInterface;
use Sylius\Bundle\SalesBundle\Model\OrderInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class OrderBuilder extends ContainerAware implements OrderBuilderInterface
{
    public function build(OrderInterface $order)
    {
        $order->getItems()->clear();

        $cart = $this->container->get('sylius_cart.provider')->getCart();

        if ($cart->isEmpty()) {
            throw new \LogicException('The cart must be not empty.');
        }

        $order->setUser($this->container->get('security.context')->getToken()->getUser());

        $orderItemManager = $this->container->get('sylius_sales.manager.item');

        foreach ($cart->getItems() as $item) {
            $orderItem = $orderItemManager->create();
            $orderItem->setVariant($item->getVariant());
            $orderItem->setQuantity($item->getQuantity());
            $orderItem->setUnitPrice($item->getVariant()->getPrice());

            $order->addItem($orderItem);
        }

        $order->calculateTotal();
    }

    public function finalize(OrderInterface $order)
    {
        $inventoryUnitManager = $this->container->get('sylius_inventory.manager.iu');
        $inventoryOperator = $this->container->get('sylius_inventory.operator');
        $variantManager = $this->container->get('sylius_assortment.manager.variant');

        foreach ($order->getItems() as $item) {
            $inventoryUnits = $inventoryOperator->decrease($item->getVariant(), $item->getQuantity());
            $order->addInventoryUnits($inventoryUnits);

            foreach ($inventoryUnits as $unit) {
                $inventoryUnitManager->persistInventoryUnit($unit);
            }

            $variantManager->persist($item->getVariant());
        }

        $this->container->get('sylius_cart.provider')->abandonCart();
    }
}
