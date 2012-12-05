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

    function it_should_be_Sylius_order()
    {
        $this->shouldImplement('Sylius\Bundle\SalesBundle\Model\OrderInterface');
    }

    function it_should_extend_Sylius_order_entity()
    {
        $this->shouldHaveType('Sylius\Bundle\SalesBundle\Entity\Order');
    }

    function it_should_contain_3_empty_items_by_default()
    {
        $this->countItems()->shouldReturn(3);
    }

    function it_should_initialize_inventory_units_collection_by_default()
    {
        $this->getInventoryUnits()->shouldHaveType('Doctrine\Common\Collections\Collection');
    }

    function it_should_not_have_any_delivery_address_by_default()
    {
        $this->getDeliveryAddress()->shouldReturn(null);
    }

    function it_should_not_have_any_billing_address_by_default()
    {
        $this->getBillingAddress()->shouldReturn(null);
    }

    function it_should_not_have_user_assigned_by_default()
    {
        $this->getUser()->shouldReturn(null);
    }

    /**
     * @param Sylius\Bundle\AddressingBundle\Model\AddressInterface $address
     */
    function its_delivery_address_shuould_be_mutable($address)
    {
        $this->setDeliveryAddress($address);
        $this->getDeliveryAddress()->shouldReturn($address);
    }

    /**
     * @param Sylius\Bundle\AddressingBundle\Model\AddressInterface $address
     */
    function its_billing_address_shuould_be_mutable($address)
    {
        $this->setBillingAddress($address);
        $this->getBillingAddress()->shouldReturn($address);
    }

    /**
     * @param FOS\UserBundle\Model\UserInterface $user
     */
    function its_user_should_be_mutable($user)
    {
        $this->setUser($user);
        $this->getUser()->shouldReturn($user);
    }
}
