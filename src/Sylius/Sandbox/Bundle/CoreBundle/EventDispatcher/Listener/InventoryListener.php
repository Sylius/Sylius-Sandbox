<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Sandbox\Bundle\CoreBundle\EventDispatcher\Listener;

use Sylius\Bundle\AssortmentBundle\EventDispatcher\Event\FilterProductEvent;
use Sylius\Bundle\AssortmentBundle\EventDispatcher\Event\FilterVariantEvent;
use Sylius\Bundle\InventoryBundle\Operator\InventoryOperatorInterface;

/**
 * Inventory change listener.
 * Refreshes inventory state every time product or variant are updated.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class InventoryListener
{
    /**
     * Inventory operator.
     *
     * @var InventoryOperatorInterface
     */
    private $inventoryOperator;

    /**
     * Constructor.
     *
     * @param InventoryOperatorInterface $inventoryOperator
     */
    public function __construct(InventoryOperatorInterface $inventoryOperator)
    {
        $this->inventoryOperator = $inventoryOperator;
    }

    /**
     * Refresh product inventory.
     *
     * @param FilterProductEvent $event
     */
    public function refreshProductInventory(FilterProductEvent $event)
    {
        $this->inventoryOperator->refresh($event->getProduct());
    }

    /**
     * Refresh variant inventory
     *
     * @param FilterVariantEvent $event
     */
    public function refreshVariantInventory(FilterVariantEvent $event)
    {
        $this->inventoryOperator->refresh($event->getVariant());
    }
}
