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
use Sylius\Bundle\AddressingBundle\Model\AddressInterface;
use Sylius\Bundle\SalesBundle\Entity\Order as BaseOrder;
use Symfony\Component\Validator\Constraints as Assert;

class Order extends BaseOrder
{
    /**
     * Total order value.
     *
     * @var float
     */
    private $total;

    /**
     * Address.
     *
     * @Assert\Valid
     */
    private $address;

    private $inventoryUnits;

    public function __construct()
    {
        parent::__construct();

        $this->inventoryUnits = new ArrayCollection();
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function setTotal($total)
    {
        $this->total = $total;
    }

    public function calculateTotal()
    {
        $total = 0.00;
        foreach ($this->getItems() as $item)
        {
            $total += $item->getQuantity() * $item->getUnitPrice();
        }

        $this->total = $total;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress(AddressInterface $address)
    {
        $this->address = $address;
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
}
