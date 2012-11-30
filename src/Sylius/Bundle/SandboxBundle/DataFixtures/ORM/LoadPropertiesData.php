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

/**
 * Default assortment product properties to play with Sylius sandbox.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class LoadPropertiesData extends DataFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->createProperty('T-Shirt brand', 'Brand', 'Property.T-Shirt.Brand');
        $this->createProperty('T-Shirt collection', 'Collection', 'Property.T-Shirt.Collection');
        $this->createProperty('T-Shirt material', 'Made of', 'Property.T-Shirt.Made-of');

        $this->createProperty('Sticker print resolution', 'Print resolution', 'Property.Sticker.Resolution');
        $this->createProperty('Sticker paper', 'Paper', 'Property.Sticker.Paper');

        $this->createProperty('Mug material', 'Material', 'Property.Mug.Material');

        $this->createProperty('Book author', 'Author', 'Property.Book.Author');
        $this->createProperty('Book ISBN', 'ISBN', 'Property.Book.ISBN');
        $this->createProperty('Book pages', 'Number of pages', 'Property.Book.Pages');
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 2;
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
        $manager = $this->getManager();

        $property = $manager->create();
        $property->setName($name);
        $property->setPresentation($presentation);

        $manager->persist($property);
        $this->setReference($reference, $property);
    }

    private function getManager()
    {
        return $this->get('sylius_assortment.manager.property');
    }
}
