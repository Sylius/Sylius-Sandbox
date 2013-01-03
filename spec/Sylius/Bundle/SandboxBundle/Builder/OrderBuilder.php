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
    /**
     * @param Doctrine\Common\Persistence\ObjectRepository             $orderItemRepository
     * @param Sylius\Bundle\CartBundle\Provider\CartProviderInterface  $cartProvider
     * @param Symfony\Component\Security\Core\SecurityContextInterface $securityContext
     */
    function let($orderItemRepository, $cartProvider, $securityContext)
    {
        $this->beConstructedWith($orderItemRepository, $cartProvider, $securityContext);
    }

    function it_should_be_initializable()
    {
        $this->shouldHaveType('Sylius\Bundle\SandboxBundle\Builder\OrderBuilder');
    }

    function it_should_be_a_Sylius_order_builder()
    {
        $this->shouldImplement('Sylius\Bundle\SalesBundle\Builder\OrderBuilderInterface');
    }

    function it_should_extend_base_Sylius_order_builder()
    {
        $this->shouldHaveType('Sylius\Bundle\SalesBundle\Builder\OrderBuilder');
    }
}
