<?php

namespace spec\Sylius\Bundle\SandboxBundle\Form\Type;

use PHPSpec2\ObjectBehavior;

/**
 * Cart item spec.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class CartItemType extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('CartItem');
    }

    function it_should_be_initializable()
    {
        $this->shouldHaveType('Sylius\Bundle\SandboxBundle\Form\Type\CartItemType');
    }

    function it_should_be_form_type()
    {
        $this->shouldImplement('Symfony\Component\Form\FormTypeInterface');
    }

    function it_should_extend_Sylius_cart_item_form_type()
    {
        $this->shouldHaveType('Sylius\Bundle\CartBundle\Form\Type\CartItemType');
    }
}
