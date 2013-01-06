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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\UserInterface;
use Sylius\Bundle\AddressingBundle\Model\AddressInterface;
use Sylius\Bundle\SalesBundle\Entity\Order as BaseOrder;
use Sylius\Bundle\SalesBundle\Model\AdjustmentInterface;
use Sylius\Bundle\ShippingBundle\Model\ShipmentInterface;
use Symfony\Component\Validator\Constraints as Assert;

class Order extends BaseOrder
{
    // Labels for tax and shipping adjustments.
    const TAX_ADJUSTMENT      = 'Tax';
    const SHIPPING_ADJUSTMENT = 'Shipping';

    /**
     * Delivery address.
     *
     * @var AddressInterface
     *
     * @Assert\Valid
     */
    private $deliveryAddress;

    /**
     * Billing address.
     *
     * @var AddressInterface
     *
     * @Assert\Valid
     */
    private $billingAddress;

    /**
     * Shipments.
     *
     * @var Collection
     */
    private $shipments;

    /**
     * Inventory units.
     *
     * @var Collection
     */
    private $inventoryUnits;

    /**
     * User.
     *
     * @var UserInterface
     */
    private $user;

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->inventoryUnits = new ArrayCollection();
        $this->shipments = new ArrayCollection();
    }

    public function getTaxTotal()
    {
        $taxTotal = 0;

        foreach ($this->getTaxAdjustments() as $adjustment) {
            $taxTotal += $adjustment->getAmount();
        }

        return $taxTotal;
    }

    public function getTaxAdjustments()
    {
        return $this->adjustments->filter(function (AdjustmentInterface $adjustment) {
            return Order::TAX_ADJUSTMENT === $adjustment->getLabel();
        });
    }

    public function removeTaxAdjustments()
    {
        foreach ($this->getTaxAdjustments() as $adjustment) {
            $this->removeAdjustment($adjustment);
        }
    }

    public function getShippingTotal()
    {
        $shippingTotal = 0;

        foreach ($this->getShippingAdjustments() as $adjustment) {
            $shippingTotal += $adjustment->getAmount();
        }

        return $shippingTotal;
    }

    public function getShippingAdjustments()
    {
        return $this->adjustments->filter(function (AdjustmentInterface $adjustment) {
            return Order::SHIPPING_ADJUSTMENT === $adjustment->getLabel();
        });
    }

    public function removeShippingAdjustments()
    {
        foreach ($this->getShippingAdjustments() as $adjustment) {
            $this->removeAdjustment($adjustment);
        }
    }

    public function getDeliveryAddress()
    {
        return $this->deliveryAddress;
    }

    public function setDeliveryAddress(AddressInterface $deliveryAddress)
    {
        $this->deliveryAddress = $deliveryAddress;
    }

    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    public function setBillingAddress(AddressInterface $billingAddress)
    {
        $this->billingAddress = $billingAddress;
    }

    public function getInventoryUnits()
    {
        return $this->inventoryUnits;
    }

    public function setInventoryUnits(Collection $inventoryUnits)
    {
        foreach ($inventoryUnits as $unit) {
            $this->inventoryUnits->add($unit);
            $unit->setOrder($this);
        }
    }

    public function getShipments()
    {
        return $this->shipments;
    }

    public function addShipment(ShipmentInterface $shipment)
    {
        if (!$this->hasShipment($shipment)) {
            $shipment->setOrder($this);
            $this->shipments->add($shipment);
        }
    }

    public function removeShipment(ShipmentInterface $shipment)
    {
        if ($this->hasShipment($shipment)) {
            $shipment->setOrder(null);
            $this->shipments->removeElement($shipment);
        }
    }

    public function hasShipment(ShipmentInterface $shipment)
    {
        return $this->shipments->contains($shipment);
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser(UserInterface $user)
    {
        $this->user = $user;
    }
}
