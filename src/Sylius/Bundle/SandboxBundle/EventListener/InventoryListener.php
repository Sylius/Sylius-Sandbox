<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\SandboxBundle\EventListener;

use Symfony\Component\EventDispatcher\GenericEvent;
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
     * Refresh product/variant inventory.
     *
     * @param GenericEvent $event
     */
    public function refreshInventory(GenericEvent $event)
    {
        $this->inventoryOperator->fillBackorders($event->getSubject());
    }
}
