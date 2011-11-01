<?php

namespace Application\Bundle\SalesBundle\Entity;

use Sylius\Bundle\CartBundle\Model\CartInterface;
use Sylius\Bundle\PaymentsBundle\Model\PaymentInterface;
use Sylius\Bundle\AddressingBundle\Model\AddressInterface;
use Sylius\Bundle\SalesBundle\Entity\Order as BaseOrder;

class Order extends BaseOrder
{
    protected $cart;
    protected $value;
    
    public $receipt = 0;
    
    public $name;
    public $surname;
    public $city;
    public $street;
    public $postcode;
    public $email;
    public $phone;
    
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
}
