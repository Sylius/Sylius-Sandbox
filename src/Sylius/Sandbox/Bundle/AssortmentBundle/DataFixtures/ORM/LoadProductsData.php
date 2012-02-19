<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Sandbox\Bundle\AssortmentBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * Default assortment products to play with Sylius sandbox.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class LoadProductsData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $manager = $this->container->get('sylius_assortment.manager.product');
        $manipulator = $this->container->get('sylius_assortment.manipulator.product');

        $faker = \Faker\Factory::create();

        foreach (range(0, 50) as $i) {
            $product = $manager->createProduct();

            $product->setName($faker->sentence);
            $product->setDescription($faker->paragraph);
            $product->setPrice($faker->randomNumber(5) / 100);
            $product->setCategory($this->getReference('Sandbox.ProductCategory-' . rand(0, 10)));

            $manipulator->create($product);

            $this->setReference('Sandbox.Product-' . $i, $product);
        }
    }

    public function getOrder()
    {
        return 4;
    }
}