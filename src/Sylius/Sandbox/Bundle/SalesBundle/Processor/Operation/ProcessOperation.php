<?php

namespace Sylius\Sandbox\Bundle\SalesBundle\Processor\Operation;

use Symfony\Component\DependencyInjection\ContainerAware;
use Sylius\Bundle\SalesBundle\Model\OrderInterface;
use Sylius\Bundle\SalesBundle\Processor\Operation\OperationInterface;

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

        foreach ($cart->getItems() as $item) {
            $orderItem = $orderItemManager->createItem();
            $orderItem->setVariant($item->getVariant());
            $orderItem->setQuantity($item->getQuantity());
            $orderItem->setUnitPrice($item->getVariant()->getPrice());

            $order->addItem($orderItem);
        }

        $order->calculateTotal();

        // Abandon current cart.
        $this->container->get('sylius_cart.provider')->abandonCart();
    }
}
