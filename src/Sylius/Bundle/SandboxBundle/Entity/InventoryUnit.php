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

use Sylius\Bundle\InventoryBundle\Entity\InventoryUnit as BaseInventoryUnit;
use Sylius\Bundle\SalesBundle\Model\OrderInterface;
use Sylius\Bundle\ShippingBundle\Model\ShipmentInterface;
use Sylius\Bundle\ShippingBundle\Model\ShipmentItemInterface;

/**
 * Custom inventory unit class.
 * Can be attached to order.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class InventoryUnit extends BaseInventoryUnit implements ShipmentItemInterface
{
    /**
     * Order.
     *
     * @var OrderInterface
     */
    private $order;

    /**
     * Shipment.
     *
     * @var ShipmentInterface
     */
    protected $shipment;

    /**
     * Shipping state.
     *
     * @var string
     */
    protected $shippingState;

    public function __construct()
    {
        parent::__construct();

        $this->shippingState = ShipmentItemInterface::STATE_READY;
    }

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
    public function setOrder(OrderInterface $order = null)
    {
        $this->order = $order;
    }

    public function getShipment()
    {
        return $this->shipment;
    }

    public function setShipment(ShipmentInterface $shipment = null)
    {
        $this->shipment = $shipment;
    }

    public function getShippingState()
    {
        return $this->shippingState;
    }

    public function setShippingState($state)
    {
        $this->shippingState = $state;
    }
}
