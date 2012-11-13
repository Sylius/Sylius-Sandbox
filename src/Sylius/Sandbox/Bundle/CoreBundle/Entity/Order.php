<?php

/*
* This file is part of the Sylius sandbox application.
*
* (c) Paweł Jędrzejewski
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Sylius\Sandbox\Bundle\SalesBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\UserInterface;
use Sylius\Bundle\AddressingBundle\Model\AddressInterface;
use Sylius\Bundle\SalesBundle\Entity\Order as BaseOrder;
use Symfony\Component\Validator\Constraints as Assert;

class Order extends BaseOrder
{
    /**
     * Delivery address.
     *
     * @var AddressInterface
     */
    private $deliveryAddress;

    /**
     * Billing address.
     *
     * @var AddressInterface
     */
    private $billingAddress;

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

    public function addInventoryUnits(array $inventoryUnits)
    {
        foreach ($inventoryUnits as $unit) {
            $unit->setOrder($this);
            $this->inventoryUnits->add($unit);
        }
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
