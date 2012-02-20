<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Sandbox\Bundle\GuardBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * Default users to play with Sylius sandbox.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class LoadUsersData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $manager = $this->container->get('sylius_guard.manager.user');
        $manipulator = $this->container->get('sylius_guard.manipulator.user');

        $faker = \Faker\Factory::create();

        foreach (range(0, 10) as $i) {
            $user = $manager->createUser();

            $user->setEmail($faker->email);
            $user->setPlainPassword($faker->word);
            $user->setEnabled($faker->boolean);

            $manipulator->create($user);

            $this->setReference('Sandbox.Guard.User-' . $i, $user);
        }
    }

    public function getOrder()
    {
        return 7;
    }
}
