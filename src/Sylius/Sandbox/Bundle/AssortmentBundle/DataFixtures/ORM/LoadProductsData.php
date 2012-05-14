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
use Sylius\Sandbox\Bundle\AssortmentBundle\Entity\Product;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Default assortment products to play with Sylius sandbox.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class LoadProductsData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $manager = $this->container->get('sylius_assortment.manager.product');
        $manipulator = $this->container->get('sylius_assortment.manipulator.product');

        $productPropertyClass = $this->container->getParameter('sylius_assortment.model.product_property.class');

        $variants = 0;
        $variantManager = $this->container->get('sylius_assortment.manager.variant');
        $variantManipulator = $this->container->get('sylius_assortment.manipulator.variant');

        $validator = $this->container->get('validator');
        $faker = \Faker\Factory::create();

        foreach (range(0, 50) as $i) {
            $product = $manager->createProduct();

            $product->setName($faker->sentence);
            $product->setDescription($faker->paragraph);
            $product->setCategory($this->getReference('Sandbox.Assortment.Category-' . rand(0, 9)));
            $product->setVariantPickingMode($faker->randomElement(array(Product::VARIANT_PICKING_CHOICE, Product::VARIANT_PICKING_MATCH)));

            $variant = $variantManager->createVariant($product);
            $variant->setPrice($faker->randomNumber(5) / 100);

            $this->setReference('Sandbox.Assortment.Variant-' . $variants, $variant);
            $variants++;

            $product->setMasterVariant($variant);
            $product->setSku($faker->randomNumber(6));

            foreach (range(0, rand(2, 5)) as $x) {
                $property = new $productPropertyClass;
                $property->setProperty($this->getReference('Sandbox.Assortment.Property-' . rand(0, 9)));
                $property->setProduct($product);
                $property->setValue($faker->word);

                $product->addProperty($property);
            }

            if (true === (Boolean) rand(0, 3)) {
                $combinations = 0;

                foreach (range(0, rand(1, 2)) as $y) {
                    $option = $this->getReference('Sandbox.Assortment.Option-' . rand(0, 4));
                    $product->addOption($option);
                }

                foreach (range(0, rand(3, 7)) as $j) {
                    $variant = $variantManager->createVariant($product);
                    $variant->setSku($faker->randomNumber(5));
                    $variant->setPrice($faker->randomNumber(5) / 100);

                    foreach ($product->getOptions() as $option) {
                        $values = $option->getValues();
                        $count = $option->countValues();

                        $variant->addOption($values[rand(0, $count - 1)]);
                    }

                    $product->addVariant($variant);

                    $this->setReference('Sandbox.Assortment.Variant-' . $variants, $variant);
                    $variants++;
                }
            }

            $manipulator->create($product);

            $this->setReference('Sandbox.Assortment.Product-' . $i, $product);
        }

        define('SYLIUS_ASSORTMENT_FIXTURES_TV', $variants);
    }

    public function getOrder()
    {
        return 6;
    }
}
