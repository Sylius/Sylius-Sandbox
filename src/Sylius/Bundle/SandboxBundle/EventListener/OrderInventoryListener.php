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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Sylius\Bundle\InventoryBundle\Operator\InventoryOperatorInterface;
use Sylius\Bundle\SalesBundle\Model\OrderInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * Order inventory listner.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class OrderInventoryListener
{
    protected $manager;
    protected $inventoryOperator;

    /**
     * Constructor.
     *
     * @param ObjectManager              $manager
     * @param InventoryOperatorInterface $inventoryOperator
     */
    public function __construct(
        ObjectManager              $manager,
        InventoryOperatorInterface $inventoryOperator
    )
    {
        $this->manager = $manager;
        $this->inventoryOperator = $inventoryOperator;
    }

    /**
     * Process inventory based on order.
     *
     * @param FilterProductEvent $event
     */
    public function processInventory(GenericEvent $event)
    {
        $order = $event->getSubject();
        $inventoryUnits = new ArrayCollection();

        foreach ($order->getItems() as $item) {
            $variant = $item->getVariant();

            $units = $this->inventoryOperator->decrease($variant, $item->getQuantity());

            foreach ($units as $unit) {
                $inventoryUnits->add($unit);
            }

            $this->manager->persist($variant);
        }

        $order->setInventoryUnits($inventoryUnits);
    }
}
