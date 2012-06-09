<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Sandbox\Bundle\CartBundle\Tests\Operator;

use Sylius\Sandbox\Bundle\AssortmentBundle\Entity\Variant\Variant;
use Sylius\Sandbox\Bundle\CartBundle\Entity\Cart;
use Sylius\Sandbox\Bundle\CartBundle\Entity\Item;
use Sylius\Sandbox\Bundle\CartBundle\Operator\CartOperator;

/**
 * Simple cart operator test.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class CartOperatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldRecalculateCartValueOnRefresh()
    {
        $cart = new Cart();

        $cart->addItem($this->createItem(10));
        $cart->addItem($this->createItem(25.99));
        $cart->addItem($this->createItem(40));

        $cartOperator = new CartOperator($this->getMockCartManager());
        $cartOperator->refresh($cart);

        $this->assertEquals(75.99, $cart->getValue());
    }

    private function createItem($price, $quantity = 1)
    {
        $variant = new Variant();
        $variant->setPrice($price);

        $item = new Item();
        $item->setVariant($variant);
        $item->setQuantity($quantity);

        return $item;
    }

    private function getMockCartManager()
    {
        return $this->getMock('Sylius\Bundle\CartBundle\Model\CartManagerInterface');
    }
}
