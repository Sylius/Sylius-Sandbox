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
use Sylius\Bundle\CartBundle\Operator\CartOperator as BaseCartOperator;

/**
 * Cart operator.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class CartOperator extends BaseCartOperator
{
    public function refresh(CartInterface $cart)
    {
        $value = 0.00;

        foreach ($cart->getItems() as $item) {
            $value += $item->getVariant()->getPrice() * $item->getQuantity();
        }

        $cart->setValue($value);

        parent::refresh($cart);
    }
}
