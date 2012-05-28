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

    private $manager;
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

        $this->createTShirtProperties();
        $this->createStickerProperties();
        $this->createMugProperties();
        $this->createBookProperties();
    }

    private function createTShirtProperties()
    {
        $property = $this->manager->createProperty();
        $property->setName('T-Shirt brand');
        $property->setPresentation('Brand');

        $this->manipulator->create($property);
        $this->setReference('Sandbox.Assortment.Property.T-Shirt.Brand', $property);

        $property = $this->manager->createProperty();
        $property->setName('T-Shirt collection');
        $property->setPresentation('Collection');

        $this->manipulator->create($property);
        $this->setReference('Sandbox.Assortment.Property.T-Shirt.Collection', $property);

        $property = $this->manager->createProperty();
        $property->setName('T-Shirt material');
        $property->setPresentation('Made of');

        $this->manipulator->create($property);
        $this->setReference('Sandbox.Assortment.Property.T-Shirt.Made-of', $property);
    }

    private function createStickerProperties()
    {
        $property = $this->manager->createProperty();
        $property->setName('Sticker print resolution');
        $property->setPresentation('Print resolution');

        $this->manipulator->create($property);
        $this->setReference('Sandbox.Assortment.Property.Sticker.Resolution', $property);

        $property = $this->manager->createProperty();
        $property->setName('Sticker paper');
        $property->setPresentation('Paper');

        $this->manipulator->create($property);
        $this->setReference('Sandbox.Assortment.Property.Sticker.Paper', $property);
    }

    private function createMugProperties()
    {
        $property = $this->manager->createProperty();
        $property->setName('Mug material');
        $property->setPresentation('Material');

        $this->manipulator->create($property);
        $this->setReference('Sandbox.Assortment.Property.Mug.Material', $property);
    }

    private function createBookProperties()
    {
        $property = $this->manager->createProperty();
        $property->setName('Book author');
        $property->setPresentation('Author');

        $this->manipulator->create($property);
        $this->setReference('Sandbox.Assortment.Property.Book.Author', $property);

        $property = $this->manager->createProperty();
        $property->setName('Book ISBN');
        $property->setPresentation('ISBN');

        $this->manipulator->create($property);
        $this->setReference('Sandbox.Assortment.Property.Book.ISBN', $property);

        $property = $this->manager->createProperty();
        $property->setName('Book pages');
        $property->setPresentation('Number of pages');

        $this->manipulator->create($property);
        $this->setReference('Sandbox.Assortment.Property.Book.Pages', $property);
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 5;
    }
}
