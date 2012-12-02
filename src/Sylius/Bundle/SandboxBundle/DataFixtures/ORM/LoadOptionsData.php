<?php

/*
 * This file is part of the sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\SandboxBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

/**
 * Default assortment product options to play with sandbox.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class LoadOptionsData extends DataFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->optionValueClass = $this->container->getParameter('sylius_assortment.model.option_value.class');

        // T-Shirt size option.
        $this->createOption(
            'T-Shirt size',
            'Size',
            array(
                'S',
                'M',
                'L',
                'XL',
                'XXL'
            ),
            'Option.T-Shirt.Size'
        );

        // T-Shirt color option.
        $this->createOption(
            'T-Shirt color',
            'Color',
            array(
                'Red',
                'Blue',
                'Green'
            ),
            'Option.T-Shirt.Color'
        );

        // Sticker size option.
        $this->createOption(
            'Sticker size',
            'Size',
            array(
                '3"',
                '5"',
                '7"'
            ),
            'Option.Sticker.Size'
        );

        // Mug type option.
        $this->createOption(
            'Mug type',
            'Type',
            array(
                'Medium mug',
                'Double mug',
                'MONSTER mug'
            ),
            'Option.Mug.Type'
        );

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 3;
    }

    /**
     * Create an option.
     *
     * @param string $name
     * @param string $presentation
     * @param array  $values
     * @param string $reference
     */
    private function createOption($name, $presentation, array $values, $reference)
    {
        $option = $this
            ->getOptionRepository()
            ->createNew()
        ;

        $option->setName($name);
        $option->setPresentation($presentation);

        foreach ($values as $text) {
            $value = new $this->optionValueClass;
            $value->setValue($text);

            $option->addValue($value);
        }

        $this
            ->getOptionManager()
            ->persist($option)
        ;

        $this->setReference($reference, $option);
    }

    private function getOptionManager()
    {
        return $this->get('sylius_assortment.manager.option');
    }

    private function getOptionRepository()
    {
        return $this->get('sylius_assortment.repository.option');
    }
}
