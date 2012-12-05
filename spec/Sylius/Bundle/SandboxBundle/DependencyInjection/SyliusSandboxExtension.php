<?php

namespace spec\Sylius\Bundle\SandboxBundle\DependencyInjection;

use PHPSpec2\ObjectBehavior;

/**
 * Sylius sandbox DI extension spec.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class SyliusSandboxExtension extends ObjectBehavior
{
    function it_should_be_initializable()
    {
        $this->shouldHaveType('Sylius\Bundle\SandboxBundle\DependencyInjection\SyliusSandboxExtension');
    }

    function it_should_be_container_extension()
    {
        $this->shouldHaveType('Symfony\Component\HttpKernel\DependencyInjection\Extension');
    }
}
