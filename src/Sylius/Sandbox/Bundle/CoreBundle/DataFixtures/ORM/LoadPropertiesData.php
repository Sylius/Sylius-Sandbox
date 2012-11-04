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
 * Default assortment product properties to play with Sylius sandbox.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class LoadPropertiesData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    /**
     * Container.
     *
     * @var ContainerInterface
     */
    private $container;

    /**
     * Property manager.
     *
     * @var PropertyManagerInterface
     */
    private $manager;

    /**
     * Property manipulator.
     *
     * @var PropertyManipulatorInterface
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
        $this->manager = $this->container->get('sylius_assortment.manager.property');
        $this->manipulator = $this->container->get('sylius_assortment.manipulator.property');

        $this->createProperty('T-Shirt brand', 'Brand', 'Sandbox.Assortment.Property.T-Shirt.Brand');
        $this->createProperty('T-Shirt collection', 'Collection', 'Sandbox.Assortment.Property.T-Shirt.Collection');
        $this->createProperty('T-Shirt material', 'Made of', 'Sandbox.Assortment.Property.T-Shirt.Made-of');

        $this->createProperty('Sticker print resolution', 'Print resolution', 'Sandbox.Assortment.Property.Sticker.Resolution');
        $this->createProperty('Sticker paper', 'Paper', 'Sandbox.Assortment.Property.Sticker.Paper');

        $this->createProperty('Mug material', 'Material', 'Sandbox.Assortment.Property.Mug.Material');

        $this->createProperty('Book author', 'Author', 'Sandbox.Assortment.Property.Book.Author');
        $this->createProperty('Book ISBN', 'ISBN', 'Sandbox.Assortment.Property.Book.ISBN');
        $this->createProperty('Book pages', 'Number of pages', 'Sandbox.Assortment.Property.Book.Pages');
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 5;
    }

    /**
     * Create property.
     *
     * @param string $name
     * @param string $presentation
     * @param string $reference
     */
    private function createProperty($name, $presentation, $reference)
    {
        $property = $this->manager->createProperty();

        $property->setName($name);
        $property->setPresentation($presentation);

        $this->manipulator->create($property);
        $this->setReference($reference, $property);
    }
}
