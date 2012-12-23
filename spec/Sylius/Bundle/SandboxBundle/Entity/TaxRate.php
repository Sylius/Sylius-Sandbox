<?php

namespace spec\Sylius\Bundle\SandboxBundle\Entity;

use PHPSpec2\ObjectBehavior;

/**
 * Tax rate model spec.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class TaxRate extends ObjectBehavior
{
    function it_should_be_initializable()
    {
        $this->shouldHaveType('Sylius\Bundle\SandboxBundle\Entity\TaxRate');
    }

    function it_should_be_a_Sylius_tax_rate()
    {
        $this->shouldImplement('Sylius\Bundle\TaxationBundle\Model\TaxRateInterface');
    }

    function it_should_extend_Sylius_tax_rate_entity()
    {
        $this->shouldHaveType('Sylius\Bundle\TaxationBundle\Entity\TaxRate');
    }

    function it_should_not_have_zone_defined_by_default()
    {
        $this->getZone()->shouldReturn(null);
    }

    /**
     * @param Sylius\Bundle\AddressingBundle\Model\ZoneInterface $zone
     */
    function it_should_allow_defining_zone($zone)
    {
        $this->setZone($zone);
        $this->getZone()->shouldReturn($zone);
    }

    /**
     * @param Sylius\Bundle\AddressingBundle\Model\ZoneInterface $zone
     */
    function it_should_allow_undefining_zone($zone)
    {
        $this->setZone($zone);
        $this->getZone()->shouldReturn($zone);

        $this->setZone(null);
        $this->getZone()->shouldReturn(null);
    }
}
