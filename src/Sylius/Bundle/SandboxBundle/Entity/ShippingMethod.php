<?php

namespace Sylius\Bundle\SandboxBundle\Entity;

use Sylius\Bundle\AddressingBundle\Model\ZoneInterface;
use Sylius\Bundle\ShippingBundle\Entity\ShippingMethod as BaseShippingMethod;

/**
 * Custom shipping method entity.
 * Shipping methods in current implementation are also "limited" by zones.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class ShippingMethod extends BaseShippingMethod
{
    private $zone;

    public function getZone()
    {
        return $this->zone;
    }

    public function setZone(ZoneInterface $zone = null)
    {
        $this->zone = $zone;
    }
}
