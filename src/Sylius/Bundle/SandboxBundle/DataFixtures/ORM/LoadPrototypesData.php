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
 * Default prototypes.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class LoadPrototypesData extends DataFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->createPrototype(
            'T-Shirt',
            array(
                'Option.T-Shirt.Size',
                'Option.T-Shirt.Color',
            ),
            array(
                'Property.T-Shirt.Collection',
                'Property.T-Shirt.Brand',
                'Property.T-Shirt.Made-of',
            )
        );

        $this->createPrototype(
            'Sticker',
            array(
                'Option.Sticker.Size',
            ),
            array(
                'Property.Sticker.Resolution',
                'Property.Sticker.Paper'
            )
        );

        $this->createPrototype(
            'Mug',
            array(
                'Option.Mug.Type',
            ),
            array(
                'Property.Mug.Material'
            )
        );

        $this->createPrototype(
            'Book',
            array(),
            array(
                'Property.Book.Author',
                'Property.Book.ISBN',
                'Property.Book.Pages',
            )
        );

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 4;
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
        $manager = $this->getPrototypeManager();
        $repository = $this->getPrototypeRepository();

        $prototype = $repository->createNew();
        $prototype->setName($name);

        foreach ($options as $option) {
            $prototype->addOption($this->getReference($option));
        }

        foreach ($properties as $property) {
            $prototype->addProperty($this->getReference($property));
        }

        $manager->persist($prototype);
    }

    private function getPrototypeManager()
    {
        return $this->get('sylius_assortment.manager.prototype');
    }

    private function getPrototypeRepository()
    {
        return $this->get('sylius_assortment.repository.prototype');
    }
}
