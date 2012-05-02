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
 * Default assortment categories to play with Sylius sandbox.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class LoadCategoriesData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $manager = $this->container->get('sylius_categorizer.manager.category');
        $manipulator = $this->container->get('sylius_categorizer.manipulator.category');
        $catalog = $this->container->get('sylius_categorizer.registry')->getCatalog('assortment');

        $faker = \Faker\Factory::create();

        foreach (range(0, 9) as $i) {
            $category = $manager->createCategory($catalog);

            $category->setName(ucfirst($faker->word));

            $manipulator->create($category);

            $this->setReference('Sandbox.Assortment.Category-' . $i, $category);
        }
    }

    public function getOrder()
    {
        return 2;
    }
}
