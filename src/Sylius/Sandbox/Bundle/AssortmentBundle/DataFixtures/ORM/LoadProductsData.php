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
use Faker\Factory as FakerFactory;
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
    /**
     * Container.
     *
     * @var ContainerInterface
     */
    private $container;

    private $manager;
    private $manipulator;

    private $productPropertyClass;

    private $totalVariants;
    private $variantManager;
    private $variantManipulator;
    private $variantGenerator;

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
        $this->manager = $this->container->get('sylius_assortment.manager.product');
        $this->manipulator = $this->container->get('sylius_assortment.manipulator.product');

        $this->productPropertyClass = $this->container->getParameter('sylius_assortment.model.product_property.class');

        $this->variantManager = $this->container->get('sylius_assortment.manager.variant');
        $this->variantManipulator = $this->container->get('sylius_assortment.manipulator.variant');
        $this->variantGenerator = $this->container->get('sylius_assortment.generator.variant');

        $this->faker = FakerFactory::create();

        // T-Shirts...
        for ($i = 1; $i <= 30; $i++) {
            $this->createTShirt($i);
        }

        // Stickers.
        for ($i = 31; $i <= 60; $i++) {
            $this->createSticker($i);
        }

        // Stickers.
        for ($i = 61; $i <= 90; $i++) {
            $this->createMug($i);
        }

        // Stickers.
        for ($i = 91; $i <= 120; $i++) {
            $this->createBook($i);
        }

        define('SYLIUS_ASSORTMENT_FIXTURES_TV', $this->totalVariants);
    }

    private function createTShirt($i)
    {
        $product = $this->manager->createProduct();

        $product->setName(sprintf('T-Shirt "%s" in different sizes and colors', $this->faker->word));
        $product->setDescription($this->faker->paragraph);
        $product->setCategory($this->getReference('Sandbox.Assortment.Category.T-Shirts'));
        $product->setVariantPickingMode(Product::VARIANT_PICKING_MATCH);

        $variant = $this->variantManager->createVariant($product);
        $variant->setPrice($this->faker->randomNumber(5) / 100);
        $variant->setSku($this->faker->randomNumber(6));
        $variant->setAvailableOn($this->faker->dateTimeThisYear);
        $variant->setOnHand($this->faker->randomNumber(1));

        $this->setReference('Sandbox.Assortment.Variant-'.$this->totalVariants, $variant);
        $this->totalVariants++;

        $product->setMasterVariant($variant);

        // T-Shirt brand.
        $property = new $this->productPropertyClass;
        $property->setProperty($this->getReference('Sandbox.Assortment.Property.T-Shirt.Brand'));
        $property->setProduct($product);
        $property->setValue($this->faker->randomElement(array('Nike', 'Adidas', 'Puma', 'Potato')));

        $product->addProperty($property);

        // T-Shirt collection.
        $property = new $this->productPropertyClass;
        $property->setProperty($this->getReference('Sandbox.Assortment.Property.T-Shirt.Collection'));
        $property->setProduct($product);

        $randomCollection = sprintf('Symfony2 %s %s', $this->faker->randomElement('Summer', 'Winter', 'Spring', 'Autumn'), rand(1995, 2012));
        $property->setValue($randomCollection);

        $product->addProperty($property);

        // T-Shirt material.
        $property = new $this->productPropertyClass;
        $property->setProperty($this->getReference('Sandbox.Assortment.Property.T-Shirt.Made-of'));
        $property->setProduct($product);
        $property->setValue($this->faker->randomElement(array('Polyester', 'Wool', 'Polyester 10% / Wool 90%', 'Potato 100%')));

        $product->addProperty($property);

        $product->addOption($this->getReference('Sandbox.Assortment.Option.T-Shirt.Size'));
        $product->addOption($this->getReference('Sandbox.Assortment.Option.T-Shirt.Color'));

        $this->variantGenerator->generate($product);

        foreach ($product->getVariants() as $variant) {
            $variant->setAvailableOn($this->faker->dateTimeThisYear);
            $variant->setPrice($this->faker->randomNumber(5) / 100);
            $variant->setSku($this->faker->randomNumber(5));
            $variant->setOnHand($this->faker->randomNumber(1));

            $this->setReference('Sandbox.Assortment.Variant-'.$this->totalVariants, $variant);
            $this->totalVariants++;
        }

        $this->manipulator->create($product);
        $this->setReference('Sandbox.Assortment.Product-'.$i, $product);
    }

    private function createSticker($i)
    {
        $product = $this->manager->createProduct();

        $product->setName(sprintf('Great sticker "%s" in different sizes', $this->faker->word));
        $product->setDescription($this->faker->paragraph);
        $product->setCategory($this->getReference('Sandbox.Assortment.Category.Stickers'));
        $product->setVariantPickingMode($this->faker->randomElement(array(Product::VARIANT_PICKING_CHOICE, Product::VARIANT_PICKING_MATCH)));

        $variant = $this->variantManager->createVariant($product);
        $variant->setPrice($this->faker->randomNumber(5) / 100);
        $variant->setSku($this->faker->randomNumber(6));
        $variant->setAvailableOn($this->faker->dateTimeThisYear);
        $variant->setOnHand($this->faker->randomNumber(1));

        $this->setReference('Sandbox.Assortment.Variant-'.$this->totalVariants, $variant);
        $this->totalVariants++;

        $product->setMasterVariant($variant);

        // Sticker resolution.
        $property = new $this->productPropertyClass;
        $property->setProperty($this->getReference('Sandbox.Assortment.Property.Sticker.Resolution'));
        $property->setProduct($product);
        $property->setValue($this->faker->randomElement(array('Waka waka', 'FULL HD', '300DPI', '200DPI')));

        $product->addProperty($property);

        // Sticker paper.
        $property = new $this->productPropertyClass;
        $property->setProperty($this->getReference('Sandbox.Assortment.Property.Sticker.Paper'));
        $property->setProduct($product);

        $randomPaper = sprintf('Paper from tree %s', $this->faker->randomElement('Wung', 'Yang', 'Lemon-San', 'Me-Gusta'));
        $property->setValue($randomPaper);

        $product->addProperty($property);

        $product->addOption($this->getReference('Sandbox.Assortment.Option.Sticker.Size'));

        $this->variantGenerator->generate($product);

        foreach ($product->getVariants() as $variant) {
            $variant->setAvailableOn($this->faker->dateTimeThisYear);
            $variant->setPrice($this->faker->randomNumber(5) / 100);
            $variant->setSku($this->faker->randomNumber(5));
            $variant->setOnHand($this->faker->randomNumber(1));

            $this->setReference('Sandbox.Assortment.Variant-'.$this->totalVariants, $variant);
            $this->totalVariants++;
        }

        $this->manipulator->create($product);
        $this->setReference('Sandbox.Assortment.Product-'.$i, $product);
    }

    private function createMug($i)
    {
        $product = $this->manager->createProduct();

        $product->setName(sprintf('Mug "%s", many types available', $this->faker->word));
        $product->setDescription($this->faker->paragraph);
        $product->setCategory($this->getReference('Sandbox.Assortment.Category.Mugs'));
        $product->setVariantPickingMode($this->faker->randomElement(array(Product::VARIANT_PICKING_CHOICE, Product::VARIANT_PICKING_MATCH)));

        $variant = $this->variantManager->createVariant($product);
        $variant->setPrice($this->faker->randomNumber(5) / 100);
        $variant->setSku($this->faker->randomNumber(6));
        $variant->setAvailableOn($this->faker->dateTimeThisYear);
        $variant->setOnHand($this->faker->randomNumber(1));

        $this->setReference('Sandbox.Assortment.Variant-'.$this->totalVariants, $variant);
        $this->totalVariants++;

        $product->setMasterVariant($variant);

        // Mug material.
        $property = new $this->productPropertyClass;
        $property->setProperty($this->getReference('Sandbox.Assortment.Property.Mug.Material'));
        $property->setProduct($product);
        $property->setValue($this->faker->randomElement(array('Invisible porcelain', 'Banana skin', 'Porcelain', 'Sand')));

        $product->addProperty($property);

        $product->addOption($this->getReference('Sandbox.Assortment.Option.Mug.Type'));

        $this->variantGenerator->generate($product);

        foreach ($product->getVariants() as $variant) {
            $variant->setAvailableOn($this->faker->dateTimeThisYear);
            $variant->setPrice($this->faker->randomNumber(5) / 100);
            $variant->setSku($this->faker->randomNumber(5));
            $variant->setOnHand($this->faker->randomNumber(1));

            $this->setReference('Sandbox.Assortment.Variant-'.$this->totalVariants, $variant);
            $this->totalVariants++;
        }

        $this->manipulator->create($product);
        $this->setReference('Sandbox.Assortment.Product-'.$i, $product);
    }

    private function createBook($i)
    {
        $product = $this->manager->createProduct();

        $author = $this->faker->name;
        $isbn = $this->faker->randomNumber(13);

        $product->setName(sprintf('Book "%s" by "%s", product wihout options', ucfirst($this->faker->word), $author));
        $product->setDescription($this->faker->paragraph);
        $product->setCategory($this->getReference('Sandbox.Assortment.Category.Books'));

        $variant = $this->variantManager->createVariant($product);
        $variant->setPrice($this->faker->randomNumber(5) / 100);
        $variant->setSku($isbn);
        $variant->setAvailableOn($this->faker->dateTimeThisYear);
        $variant->setOnHand($this->faker->randomNumber(1));

        $this->setReference('Sandbox.Assortment.Variant-'.$this->totalVariants, $variant);
        $this->totalVariants++;

        $product->setMasterVariant($variant);

        // Book author.
        $property = new $this->productPropertyClass;
        $property->setProperty($this->getReference('Sandbox.Assortment.Property.Book.Author'));
        $property->setProduct($product);
        $property->setValue($author);

        $product->addProperty($property);

        // Book ISBN.
        $property = new $this->productPropertyClass;
        $property->setProperty($this->getReference('Sandbox.Assortment.Property.Book.ISBN'));
        $property->setProduct($product);
        $property->setValue($isbn);

        $product->addProperty($property);

        // Book ISBN.
        $property = new $this->productPropertyClass;
        $property->setProperty($this->getReference('Sandbox.Assortment.Property.Book.Pages'));
        $property->setProduct($product);
        $property->setValue($this->faker->randomNumber(3));

        $product->addProperty($property);

        $this->manipulator->create($product);
        $this->setReference('Sandbox.Assortment.Product-'.$i, $product);
    }

    public function getOrder()
    {
        return 6;
    }
}
