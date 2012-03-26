<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Sandbox\Bundle\CartBundle\Resolver;

use Sylius\Bundle\AssortmentBundle\Model\ProductManagerInterface;
use Sylius\Bundle\CartBundle\Model\ItemManagerInterface;
use Sylius\Bundle\CartBundle\Resolver\ItemResolverInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Item resolver for cart bundle.
 * Returns proper item objects for cart add and remove actions.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class ItemResolver implements ItemResolverInterface
{
    /**
     * Item manager.
     *
     * @var ItemManagerInterface
     */
    private $itemManager;

    /**
     * Product manager.
     *
     * @var ProductManagerInterface
     */
    private $productManager;

    /**
     * Constructor.
     *
     * @param ItemManagerInterface    $itemManager
     * @param ProductManagerInterface $productManager
     */
    public function __construct(ItemManagerInterface $itemManager, ProductManagerInterface $productManager)
    {
        $this->itemManager = $itemManager;
        $this->productManager = $productManager;
    }

    /**
     * {@inheritdoc}
     */
    public function resolveItemToAdd(Request $request)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function resolveItemToRemove(Request $request)
    {
    }
}
