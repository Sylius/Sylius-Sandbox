<?php

/*
* This file is part of the Sylius sandbox application.
*
* (c) Paweł Jędrzejewski
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Sylius\Sandbox\Bundle\SalesBundle\Entity;

use Sylius\Bundle\CartBundle\Model\CartInterface;
use Sylius\Bundle\AddressingBundle\Model\AddressInterface;
use Sylius\Bundle\SalesBundle\Entity\Order as BaseOrder;

class Order extends BaseOrder
{
    protected $cart;
    protected $value;
    protected $address;

    public function getCart()
    {
        return $this->cart;
    }

    public function setCart(CartInterface $cart)
    {
        $this->cart = $cart;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress(AddressInterface $address)
    {
        $this->address = $address;
    }
}
