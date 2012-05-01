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
 * Default assortment product options to play with Sylius sandbox.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class LoadOptionsData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    /**
     * Container.
     *
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $manager = $this->container->get('sylius_assortment.manager.option');
        $manipulator = $this->container->get('sylius_assortment.manipulator.option');
        $optionValueClass = $this->container->getParameter('sylius_assortment.model.option_value.class');

        $faker = \Faker\Factory::create();

        foreach (range(0, 9) as $i) {
            $option = $manager->createOption();

            $option->setName($faker->word);
            $option->setPresentation($faker->word);

            foreach (range(0, rand(2, 5)) as $x) {
                $value = new $optionValueClass;
                $value->setValue($faker->word);

                $option->addValue($value);
            }

            $manipulator->create($option);

            $this->setReference('Sandbox.Assortment.Option-' . $i, $option);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 4;
    }
}
