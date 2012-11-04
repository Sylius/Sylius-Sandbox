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
use Faker\Factory as FakerFactory;
use Sylius\Bundle\AssortmentBundle\Model\CustomizableProductInterface;
use Sylius\Sandbox\Bundle\CoreBundle\Entity\Product;
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

    /**
     * Product manager.
     *
     * @var ProductManagerInterface
     */
    private $manager;

    /**
     * Product manipulator.
     *
     * @var ProductManipulatorInterface
     */
    private $manipulator;

    /**
     * Product property entity class.
     *
     * @var string
     */
    private $productPropertyClass;

    /**
     * Total variants created.
     *
     * @var integer
     */
    private $totalVariants;

    /**
     * Variant manager.
     *
     * @var VariantManagerInterface
     */
    private $variantManager;

    /**
     * Variant manipulator.
     *
     * @var VariantManipulatorInterface
     */
    private $variantManipulator;

    /**
     * Variants generator.
     *
     * @var VariantGeneratorInterface
     */
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

        // Mugs.
        for ($i = 61; $i <= 90; $i++) {
            $this->createMug($i);
        }

        // Books.
        for ($i = 91; $i <= 120; $i++) {
            $this->createBook($i);
        }

        // Define constant with number of total variants created.
        define('SYLIUS_ASSORTMENT_FIXTURES_TV', $this->totalVariants);
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 6;
    }

    /**
     * Creates t-shirt product.
     *
     * @param integer $i
     */
    private function createTShirt($i)
    {
        $product = $this->manager->createProduct();

        $product->setName(sprintf('T-Shirt "%s" in different sizes and colors', $this->faker->word));
        $product->setDescription($this->faker->paragraph);
        $product->setCategory($this->getReference('Sandbox.Assortment.Category.T-Shirts'));
        $product->setVariantPickingMode(Product::VARIANT_PICKING_MATCH);

        $this->addMasterVariant($product);

        // T-Shirt brand.
        $randomBrand = $this->faker->randomElement(array('Nike', 'Adidas', 'Puma', 'Potato'));
        $this->addProperty($product, 'Sandbox.Assortment.Property.T-Shirt.Brand', $randomBrand);

        // T-Shirt collection.
        $randomCollection = sprintf('Symfony2 %s %s', $this->faker->randomElement(array('Summer', 'Winter', 'Spring', 'Autumn')), rand(1995, 2012));
        $this->addProperty($product, 'Sandbox.Assortment.Property.T-Shirt.Collection', $randomCollection);

        // T-Shirt material.
        $randomMaterial = $this->faker->randomElement(array('Polyester', 'Wool', 'Polyester 10% / Wool 90%', 'Potato 100%'));
        $this->addProperty($product, 'Sandbox.Assortment.Property.T-Shirt.Made-of', $randomMaterial);

        $product->addOption($this->getReference('Sandbox.Assortment.Option.T-Shirt.Size'));
        $product->addOption($this->getReference('Sandbox.Assortment.Option.T-Shirt.Color'));

        $this->generateVariants($product);

        $this->manipulator->create($product);
        $this->setReference('Sandbox.Assortment.Product-'.$i, $product);
    }

    /**
     * Create sticker product.
     *
     * @param integer $i
     */
    private function createSticker($i)
    {
        $product = $this->manager->createProduct();

        $product->setName(sprintf('Great sticker "%s" in different sizes', $this->faker->word));
        $product->setDescription($this->faker->paragraph);
        $product->setCategory($this->getReference('Sandbox.Assortment.Category.Stickers'));
        $product->setVariantPickingMode($this->faker->randomElement(array(Product::VARIANT_PICKING_CHOICE, Product::VARIANT_PICKING_MATCH)));

        $this->addMasterVariant($product);

        // Sticker resolution.
        $randomResolution = $this->faker->randomElement(array('Waka waka', 'FULL HD', '300DPI', '200DPI'));
        $this->addProperty($product, 'Sandbox.Assortment.Property.Sticker.Resolution', $randomResolution);

        // Sticker paper.
        $randomPaper = sprintf('Paper from tree %s', $this->faker->randomElement(array('Wung', 'Yang', 'Lemon-San', 'Me-Gusta')));
        $this->addProperty($product, 'Sandbox.Assortment.Property.Sticker.Paper', $randomPaper);

        $product->addOption($this->getReference('Sandbox.Assortment.Option.Sticker.Size'));

        $this->generateVariants($product);

        $this->manipulator->create($product);
        $this->setReference('Sandbox.Assortment.Product-'.$i, $product);
    }

    /**
     * Create mug product.
     *
     * @param integer $i
     */
    private function createMug($i)
    {
        $product = $this->manager->createProduct();

        $product->setName(sprintf('Mug "%s", many types available', $this->faker->word));
        $product->setDescription($this->faker->paragraph);
        $product->setCategory($this->getReference('Sandbox.Assortment.Category.Mugs'));
        $product->setVariantPickingMode(Product::VARIANT_PICKING_CHOICE);

        $this->addMasterVariant($product);

        $randomMugMaterial = $this->faker->randomElement(array('Invisible porcelain', 'Banana skin', 'Porcelain', 'Sand'));
        $this->addProperty($product, 'Sandbox.Assortment.Property.Mug.Material', $randomMugMaterial);

        $product->addOption($this->getReference('Sandbox.Assortment.Option.Mug.Type'));

        $this->generateVariants($product);

        $this->manipulator->create($product);
        $this->setReference('Sandbox.Assortment.Product-'.$i, $product);
    }

    /**
     * Create book product.
     *
     * @param integer $i
     */
    private function createBook($i)
    {
        $product = $this->manager->createProduct();

        $author = $this->faker->name;
        $isbn = $this->faker->randomNumber(13);

        $product->setName(sprintf('Book "%s" by "%s", product wihout options', ucfirst($this->faker->word), $author));
        $product->setDescription($this->faker->paragraph);
        $product->setCategory($this->getReference('Sandbox.Assortment.Category.Books'));

        $this->addMasterVariant($product, $isbn);

        $this->addProperty($product, 'Sandbox.Assortment.Property.Book.Author', $author);
        $this->addProperty($product, 'Sandbox.Assortment.Property.Book.ISBN', $isbn);
        $this->addProperty($product, 'Sandbox.Assortment.Property.Book.Pages', $this->faker->randomNumber(3));

        $this->manipulator->create($product);
        $this->setReference('Sandbox.Assortment.Product-'.$i, $product);
    }

    /**
     * Generates all possible variants with random prices.
     *
     * @param CustomizableProductInterface $product
     */
    private function generateVariants(CustomizableProductInterface $product)
    {
        $this->variantGenerator->generate($product);

        foreach ($product->getVariants() as $variant) {
            $variant->setAvailableOn($this->faker->dateTimeThisYear);
            $variant->setPrice($this->faker->randomNumber(5) / 100);
            $variant->setSku($this->faker->randomNumber(5));
            $variant->setOnHand($this->faker->randomNumber(1));

            $this->setReference('Sandbox.Assortment.Variant-'.$this->totalVariants, $variant);
            $this->totalVariants++;
        }
    }

    /**
     * Adds master variant to product.
     *
     * @param CustomizableProductInterface $product
     * @param string                       $sku
     */
    private function addMasterVariant(CustomizableProductInterface $product, $sku = null)
    {
        if (null === $sku) {
            $sku = $this->faker->randomNumber(6);
        }

        $variant = $this->variantManager->createVariant($product);
        $variant->setPrice($this->faker->randomNumber(5) / 100);
        $variant->setSku($sku);
        $variant->setAvailableOn($this->faker->dateTimeThisYear);
        $variant->setOnHand($this->faker->randomNumber(1));

        $this->setReference('Sandbox.Assortment.Variant-'.$this->totalVariants, $variant);
        $this->totalVariants++;

        $product->setMasterVariant($variant);
    }

    /**
     * Adds property to product with given value.
     *
     * @param CustomizableProductInterface $product
     * @param string                       $propertyReference
     * @param string                       $value
     */
    private function addProperty(CustomizableProductInterface $product, $propertyReference, $value)
    {
        $property = new $this->productPropertyClass;
        $property->setProperty($this->getReference($propertyReference));
        $property->setProduct($product);
        $property->setValue($value);

        $product->addProperty($property);
    }
}
