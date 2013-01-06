<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\SandboxBundle\Entity;

use Sylius\Bundle\ShippingBundle\Entity\Shipment as BaseShipment;
use Sylius\Bundle\SalesBundle\Model\OrderInterface;

/**
 * Shipment attached to order.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class Shipment extends BaseShipment
{
    /**
     * Order.
     *
     * @var OrderInterface
     */
    private $order;

    /**
     * Get order.
     *
     * @return OrderInterface
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set order.
     *
     * @param OrderInterface $order
     */
    public function setOrder(OrderInterface $order)
    {
        $this->order = $order;
    }
}
