<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Sandbox\Bundle\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Default prototypes.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class LoadPrototypesData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    /**
     * Container.
     *
     * @var ContainerInterface
     */
    private $container;

    /**
     * Prototype manager.
     *
     * @var PrototypeManagerInterface
     */
    private $manager;

    /**
     * Prototype manipulator.
     *
     * @var PrototypeManipulatorInterface
     */
    private $manipulator;

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
        $this->manager = $this->container->get('sylius_assortment.manager.prototype');
        $this->manipulator = $this->container->get('sylius_assortment.manipulator.prototype');

        $this->createPrototype(
            'T-Shirt',
            array(
                'Sandbox.Assortment.Option.T-Shirt.Size',
                'Sandbox.Assortment.Option.T-Shirt.Color',
            ),
            array(
                'Sandbox.Assortment.Property.T-Shirt.Collection',
                'Sandbox.Assortment.Property.T-Shirt.Brand',
                'Sandbox.Assortment.Property.T-Shirt.Made-of',
            )
        );

        $this->createPrototype(
            'Sticker',
            array(
                'Sandbox.Assortment.Option.Sticker.Size',
            ),
            array(
                'Sandbox.Assortment.Property.Sticker.Resolution',
                'Sandbox.Assortment.Property.Sticker.Paper'
            )
        );

        $this->createPrototype(
            'Mug',
            array(
                'Sandbox.Assortment.Option.Mug.Type',
            ),
            array(
                'Sandbox.Assortment.Property.Mug.Material'
            )
        );

        $this->createPrototype(
            'Book',
            array(),
            array(
                'Sandbox.Assortment.Property.Book.Author',
                'Sandbox.Assortment.Property.Book.ISBN',
                'Sandbox.Assortment.Property.Book.Pages',
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 7;
    }

    /**
     * Create prototype.
     *
     * @param string $name
     * @param array  $options
     * @param array  $properties
     */
    private function createPrototype($name, array $options, array $properties)
    {
        $prototype = $this->manager->createPrototype();

        $prototype->setName($name);

        foreach ($options as $option) {
            $prototype->addOption($this->getReference($option));
        }

        foreach ($properties as $property) {
            $prototype->addProperty($this->getReference($property));
        }

        $this->manipulator->create($prototype);
    }
}
