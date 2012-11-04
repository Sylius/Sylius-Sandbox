<?php

/*
 * This file is part of the sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sandbox\Bundle\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Default assortment product options to play with sandbox.
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
     * Options manager.
     *
     * @var OptionManagerInterface
     */
    private $manager;

    /**
     * Option manipulator.
     *
     * @var OptionManipulatorInterface
     */
    private $manipulator;

    /**
     * Option value entity class.
     *
     * @var string
     */
    private $optionValueClass;

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
        $this->manager = $this->container->get('sylius_assortment.manager.option');
        $this->manipulator = $this->container->get('sylius_assortment.manipulator.option');
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
            'Sandbox.Assortment.Option.T-Shirt.Size'
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
            'Sandbox.Assortment.Option.T-Shirt.Color'
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
            'Sandbox.Assortment.Option.Sticker.Size'
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
            'Sandbox.Assortment.Option.Mug.Type'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 4;
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
        $option = $this->manager->createOption();

        $option->setName($name);
        $option->setPresentation($presentation);

        foreach ($values as $text) {
            $value = new $this->optionValueClass;
            $value->setValue($text);

            $option->addValue($value);
        }

        $this->manipulator->create($option);
        $this->setReference($reference, $option);
    }
}
