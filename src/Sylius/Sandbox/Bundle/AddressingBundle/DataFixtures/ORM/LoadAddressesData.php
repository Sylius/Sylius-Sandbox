<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Sandbox\Bundle\AddressingBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * Default addresses to play with Sylius sandbox.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class LoadAddressesData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $manager = $this->container->get('sylius_addressing.manager.address');
        $manipulator = $this->container->get('sylius_addressing.manipulator.address');

        $faker = \Faker\Factory::create();

        foreach (range(0, 49) as $i) {
            $address = $manager->createAddress();

            $address->setName($faker->firstName);
            $address->setSurname($faker->lastName);
            $address->setCity($faker->city);
            $address->setStreet($faker->streetAddress);
            $address->setPostcode($faker->postcode);
            $address->setEmail($faker->email);
            $address->setPhone($faker->phoneNumber);

            $manipulator->create($address);

            $this->setReference('Sandbox.Addressing.Address-' . $i, $address);
        }
    }

    public function getOrder()
    {
        return 1;
    }
}