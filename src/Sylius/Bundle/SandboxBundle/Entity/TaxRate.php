<?php

namespace Sylius\Bundle\SandboxBundle\Entity;

use Sylius\Bundle\AddressingBundle\Model\ZoneInterface;
use Sylius\Bundle\TaxationBundle\Entity\TaxRate as BaseTaxRate;

/**
 * Tax rate entity.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class TaxRate extends BaseTaxRate
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
