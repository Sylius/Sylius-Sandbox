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

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

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

    private $manager;
    private $manipulator;
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

        $this->createTShirtSizeOption();
        $this->createTShirtColorOption();
        $this->createStickerSizeOption();
        $this->createMugTypeOption();
    }

    private function createTShirtSizeOption()
    {
        $option = $this->manager->createOption();

        $option->setName('T-Shirt size');
        $option->setPresentation('Size');

        $value = new $this->optionValueClass;
        $value->setValue('S');
        $option->addValue($value);

        $value = new $this->optionValueClass;
        $value->setValue('M');
        $option->addValue($value);

        $value = new $this->optionValueClass;
        $value->setValue('L');
        $option->addValue($value);

        $value = new $this->optionValueClass;
        $value->setValue('XL');
        $option->addValue($value);

        $value = new $this->optionValueClass;
        $value->setValue('XXL');
        $option->addValue($value);

        $this->manipulator->create($option);
        $this->setReference('Sandbox.Assortment.Option.T-Shirt.Size', $option);
    }

    private function createTShirtColorOption()
    {
        $option = $this->manager->createOption();

        $option->setName('T-Shirt color');
        $option->setPresentation('Color');

        $value = new $this->optionValueClass;
        $value->setValue('Red');
        $option->addValue($value);


        $value = new $this->optionValueClass;
        $value->setValue('Blue');
        $option->addValue($value);

        $value = new $this->optionValueClass;
        $value->setValue('Green');
        $option->addValue($value);

        $this->manipulator->create($option);
        $this->setReference('Sandbox.Assortment.Option.T-Shirt.Color', $option);
    }

    private function createStickerSizeOption()
    {
        $option = $this->manager->createOption();

        $option->setName('Sticker size');
        $option->setPresentation('Size');

        $value = new $this->optionValueClass;
        $value->setValue('3"');
        $option->addValue($value);

        $value = new $this->optionValueClass;
        $value->setValue('5"');
        $option->addValue($value);

        $value = new $this->optionValueClass;
        $value->setValue('7"');
        $option->addValue($value);

        $this->manipulator->create($option);
        $this->setReference('Sandbox.Assortment.Option.Sticker.Size', $option);
    }

    private function createMugTypeOption()
    {
        $option = $this->manager->createOption();

        $option->setName('Mug type');
        $option->setPresentation('Type');

        $value = new $this->optionValueClass;
        $value->setValue('Medium mug');
        $option->addValue($value);

        $value = new $this->optionValueClass;
        $value->setValue('Double mug');
        $option->addValue($value);

        $value = new $this->optionValueClass;
        $value->setValue('MONSTER mug');
        $option->addValue($value);

        $this->manipulator->create($option);
        $this->setReference('Sandbox.Assortment.Option.Mug.Type', $option);
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 4;
    }
}
