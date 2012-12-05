<?php

namespace spec\Sylius\Bundle\SandboxBundle\Entity;

use PHPSpec2\ObjectBehavior;

/**
 * Inventory unit entity spec.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class InventoryUnit extends ObjectBehavior
{
    function it_should_be_initializable()
    {
        $this->shouldHaveType('Sylius\Bundle\SandboxBundle\Entity\InventoryUnit');
    }

    function it_should_be_Sylius_inventory_unit()
    {
        $this->shouldImplement('Sylius\Bundle\InventoryBundle\Model\InventoryUnitInterface');
    }

    function it_should_extend_Sylius_inventory_unit_entity()
    {
        $this->shouldHaveType('Sylius\Bundle\InventoryBundle\Entity\InventoryUnit');
    }

    function it_should_not_belong_to_any_order_by_default()
    {
        $this->getOrder()->shouldReturn(null);
    }

    /**
     * @param Sylius\Bundle\SalesBundle\Model\OrderInterface $order
     */
    function it_should_allow_to_define_the_order($order)
    {
        $this->setOrder($order);
        $this->getOrder()->shouldReturn($order);
    }
}
