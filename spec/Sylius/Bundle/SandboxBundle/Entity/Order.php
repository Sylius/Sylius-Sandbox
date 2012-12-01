<?php

namespace spec\Sylius\Bundle\SandboxBundle\Entity;

use PHPSpec2\ObjectBehavior;

/**
 * Order entity spec.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class Order extends ObjectBehavior
{
    function it_should_be_initializable()
    {
        $this->shouldHaveType('Sylius\Bundle\SandboxBundle\Entity\Order');
    }

    function it_should_be_sylius_order()
    {
        $this->shouldImplement('Sylius\Bundle\SalesBundle\Model\OrderInterface');
    }

    function it_should_contain_3_empty_items_by_default()
    {
        $this->countItems()->shouldReturn(3);
    }
}
