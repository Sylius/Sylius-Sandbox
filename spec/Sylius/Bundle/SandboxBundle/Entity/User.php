<?php

namespace spec\Sylius\Bundle\SandboxBundle\Entity;

use PHPSpec2\ObjectBehavior;

/**
 * User spec.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class User extends ObjectBehavior
{
    function it_should_be_initializable()
    {
        $this->shouldHaveType('Sylius\Bundle\SandboxBundle\Entity\User');
    }

    function it_should_be_advanced_security_user()
    {
        $this->shouldImplement('Symfony\Component\Security\Core\User\AdvancedUserInterface');
    }

    function it_should_implement_fos_user_bundle_interface()
    {
        $this->shouldImplement('FOS\UserBundle\Model\UserInterface');
    }

    function it_should_extend_fos_user_bundle_entity()
    {
        $this->shouldHaveType('FOS\UserBundle\Entity\User');
    }
}
