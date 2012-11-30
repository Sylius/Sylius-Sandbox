<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\SandboxBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Sylius\Bundle\SandboxBundle\Entity\User;

/**
 * User fixtures.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class LoadUsersData extends DataFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();

        $user->setUsername('administrator');
        $user->setEmail('administrator@example.com');
        $user->setPlainPassword('abrakadabra');
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_SYLIUS_ADMIN'));

        $manager->persist($user);
        $manager->flush();

        $this->setReference('User-Administrator', $user);

        $user = new User();

        $user->setUsername('john');
        $user->setEmail('john@example.com');
        $user->setPlainPassword('lumos');
        $user->setEnabled(true);

        $manager->persist($user);
        $manager->flush();

        $this->setReference('User-John', $user);
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 1;
    }
}
