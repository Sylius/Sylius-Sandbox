<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Sandbox\Bundle\CartBundle\Operator;

use Sylius\Bundle\CartBundle\Model\CartInterface;
use Sylius\Bundle\CartBundle\Model\ItemInterface;
use Sylius\Bundle\CartBundle\Operator\CartOperatorInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Cart operator.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class CartOperator extends ContainerAware implements CartOperatorInterface
{
    public function addItem(CartInterface $cart, ItemInterface $item)
    {
        $product = $item->getProduct();

        foreach ($cart->getItems() as $existingItem) {
            if ($existingItem->getProduct() === $product) {
                $existingItem->setQuantity($existingItem->getQuantity() + $item->getQuantity());

                return;
            }
        }

        $cart->addItem($item);
    }

    public function removeItem(CartInterface $cart, ItemInterface $item)
    {
        $cart->removeItem($item);
    }

    public function refresh(CartInterface $cart)
    {
        $value = 0.00;
        $totalItems = $cart->countItems();

        foreach ($cart->getItems() as $item) {
            $value += $item->getProduct()->getPrice() * $item->getQuantity();
        }

        $cart->setValue($value);
        $cart->setTotalItems($totalItems);
    }

    public function validate(CartInterface $cart)
    {
        return true;
    }

    public function clear(CartInterface $cart)
    {
        $this->container->get('sylius_cart.manager.cart')->removeCart($cart);
    }

    public function save(CartInterface $cart)
    {
        $this->container->get('sylius_cart.manager.cart')->persistCart($cart);
    }
}
