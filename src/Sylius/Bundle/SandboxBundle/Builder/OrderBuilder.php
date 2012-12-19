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

        $orderItemRepository = $this->container->get('sylius_sales.repository.item');

        foreach ($cart->getItems() as $item) {
            $orderItem = $orderItemRepository->createNew();
            $orderItem->setVariant($item->getVariant());
            $orderItem->setQuantity($item->getQuantity());
            $orderItem->setUnitPrice($item->getVariant()->getPrice());

            $order->addItem($orderItem);
        }

        $order->calculateTotal();
    }

    public function finalize(OrderInterface $order)
    {
        $inventoryOperator = $this->container->get('sylius_inventory.operator');
        $variantManager = $this->container->get('sylius_assortment.manager.variant');

        foreach ($order->getItems() as $item) {
            $variant = $item->getVariant();

            $inventoryUnits = $inventoryOperator->decrease($variant, $item->getQuantity());
            $order->setInventoryUnits($inventoryUnits);

            $variantManager->persist($variant);
            $variantManager->flush($variant);
        }

        $this->container->get('sylius_cart.provider')->abandonCart();
    }
}
