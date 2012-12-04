<?php

namespace spec\Sylius\Bundle\SandboxBundle\Resolver;

use PHPSpec2\ObjectBehavior;

/**
 * Item resolver spec.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class ItemResolver extends ObjectBehavior
{
    /**
     * @param Doctrine\Common\Persistence\ObjectRepository                  $productRepository
     * @param Symfony\Component\Form\FormFactory                            $formFactory
     * @param Sylius\Bundle\InventoryBundle\Resolver\StockResolverInterface $stockResolver
     */
    function let($productRepository, $formFactory, $stockResolver)
    {
        $this->beConstructedWith($productRepository, $formFactory, $stockResolver);
    }

    function it_should_be_initializable()
    {
        $this->shouldHaveType('Sylius\Bundle\SandboxBundle\Resolver\ItemResolver');
    }

    function it_should_be_cart_item_resolver()
    {
        $this->shouldImplement('Sylius\Bundle\CartBundle\Resolver\ItemResolverInterface');
    }
}
