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
        $cart->setLocked(true);

        // Set order value.
        $order->setCart($cart);

        $orderValue = 0.00;

        foreach ($cart->getItems() as $item) {
            $orderValue += $item->getVariant()->getPrice() * $item->getQuantity();
        }

        $order->setValue($orderValue);

        // Abandon current cart.
        $this->container->get('sylius_cart.provider')->abandonCart();
    }
}
