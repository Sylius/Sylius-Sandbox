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

use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * Dummy order shipping listener.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class OrderShippingListener
{
    /**
     * Constructor.
     *
     * @param ObjectRepository $shipmentRepository
     */
    public function __construct(ObjectRepository $shipmentRepository)
    {
        $this->shipmentRepository = $shipmentRepository;
    }

    /**
     * Create a dummy shipment on the order.
     *
     * @param GenericEvent $event
     */
    public function processShipments(GenericEvent $event)
    {
        $order = $event->getSubject();
        $shipment = $this->shipmentRepository->createNew();

        foreach ($order->getInventoryUnits() as $item) {
            $shipment->addItem($item);
        }

        $order->addShipment($shipment);
    }
}
