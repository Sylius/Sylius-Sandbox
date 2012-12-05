<?php

namespace spec\Sylius\Bundle\SandboxBundle\Entity;

use PHPSpec2\ObjectBehavior;

/**
 * Cart entity spec.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class Cart extends ObjectBehavior
{
    function it_should_be_initializable()
    {
        $this->shouldHaveType('Sylius\Bundle\SandboxBundle\Entity\Cart');
    }

    function it_should_extend_Sylius_cart_entity()
    {
        $this->shouldHaveType('Sylius\Bundle\CartBundle\Entity\Cart');
    }
}
