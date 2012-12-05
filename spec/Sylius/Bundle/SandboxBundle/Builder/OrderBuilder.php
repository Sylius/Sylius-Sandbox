<?php

namespace spec\Sylius\Bundle\SandboxBundle\Builder;

use PHPSpec2\ObjectBehavior;

/**
 * Order builder spec.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class OrderBuilder extends ObjectBehavior
{
    function it_should_be_initializable()
    {
        $this->shouldHaveType('Sylius\Bundle\SandboxBundle\Builder\OrderBuilder');
    }

    function it_should_be_Sylius_order_builder()
    {
        $this->shouldImplement('Sylius\Bundle\SalesBundle\Builder\OrderBuilderInterface');
    }
}
