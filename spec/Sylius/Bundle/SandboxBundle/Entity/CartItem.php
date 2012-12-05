<?php

namespace spec\Sylius\Bundle\SandboxBundle\Entity;

use PHPSpec2\ObjectBehavior;

/**
 * Cart item entity spec.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class CartItem extends ObjectBehavior
{
    function it_should_be_initializable()
    {
        $this->shouldHaveType('Sylius\Bundle\SandboxBundle\Entity\CartItem');
    }

    function it_should_be_Sylius_cart_item()
    {
        $this->shouldImplement('Sylius\Bundle\CartBundle\Model\CartItemInterface');
    }

    function it_should_extend_Sylius_cart_item_entity()
    {
        $this->shouldHaveType('Sylius\Bundle\CartBundle\Entity\CartItem');
    }

    function it_should_not_have_assigned_variant_by_default()
    {
        $this->getVariant()->shouldReturn(null);
    }

    /**
     * @param Sylius\Bundle\AssortmentBundle\Model\Variant\VariantInterface $variant
     */
    function it_should_allow_assigning_a_variant($variant)
    {
        $this->setVariant($variant);
        $this->getVariant()->shouldReturn($variant);
    }

    /**
     * @param Sylius\Bundle\AssortmentBundle\Model\Variant\VariantInterface $variantA
     * @param Sylius\Bundle\AssortmentBundle\Model\Variant\VariantInterface $variantB
     * @param Sylius\Bundle\SandboxBundle\Entity\CartItem                   $cartItem
     */
    function it_should_be_equal_to_item_with_same_variant($variantA, $variantB, $cartItem)
    {
        $variantA->getId()->willReturn(3);
        $variantB->getId()->willReturn(3);

        $cartItem->getVariant()->willReturn($variantB);
        $this->setVariant($variantA);

        $this->equals($cartItem)->shouldReturn(true);
    }

    /**
     * @param Sylius\Bundle\AssortmentBundle\Model\Variant\VariantInterface $variantA
     * @param Sylius\Bundle\AssortmentBundle\Model\Variant\VariantInterface $variantB
     * @param Sylius\Bundle\SandboxBundle\Entity\CartItem                   $cartItem
     */
    function it_should_not_be_equal_to_item_with_different_variant($variantA, $variantB, $cartItem)
    {
        $variantA->getId()->willReturn(3);
        $variantB->getId()->willReturn(6);

        $cartItem->getVariant()->willReturn($variantB);
        $this->setVariant($variantA);

        $this->equals($cartItem)->shouldReturn(false);
    }
}
