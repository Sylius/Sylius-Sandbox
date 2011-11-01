<?php

namespace Application\Bundle\SalesBundle\Processor\Operation;

use Symfony\Component\DependencyInjection\ContainerAware;
use Sylius\Bundle\SalesBundle\Model\OrderInterface;
use Sylius\Bundle\SalesBundle\Processor\Operation\OperationInterface;

class ProcessOperation extends ContainerAware implements OperationInterface
{
    public function process(OrderInterface $order)
    {
        // Lock cart.
        $cart = $this->container->get('sylius_cart.provider')->getCart();
        $cart->setLocked(true);
        
        // Set order value.
        $order->setCart($cart);
        $order->setValue($cart->getTotalPrice() + 25.00);
        
        // Clear cart.
        $cart = $this->container->get('sylius_cart.manager.cart')->createCart();
        $this->container->get('sylius_cart.provider')->setCart($cart);
        $this->container->get('request')->getSession()->set('sylius_cart.id', false);
    }
}
