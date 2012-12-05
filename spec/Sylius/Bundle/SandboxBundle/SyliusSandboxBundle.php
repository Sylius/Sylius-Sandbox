<?php

namespace spec\Sylius\Bundle\SandboxBundle;

use PHPSpec2\ObjectBehavior;

/**
 * Sylius sandbox bundle spec.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class SyliusSandboxBundle extends ObjectBehavior
{
    function it_should_be_initializable()
    {
        $this->shouldHaveType('Sylius\Bundle\SandboxBundle\SyliusSandboxBundle');
    }

    function it_should_be_a_bundle()
    {
        $this->shouldImplement('Symfony\Component\HttpKernel\Bundle\BundleInterface');
    }
}
