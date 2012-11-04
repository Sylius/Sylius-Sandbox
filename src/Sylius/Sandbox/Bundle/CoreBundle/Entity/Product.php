<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Sandbox\Bundle\CoreBundle\Entity;

use Sylius\Bundle\AssortmentBundle\Entity\CustomizableProduct as BaseProduct;
use Sylius\Bundle\CategorizerBundle\Model\CategoryInterface;
use Sylius\Bundle\InventoryBundle\Model\StockableInterface;
use Symfony\Component\Validator\Constraints as Assert;

class Product extends BaseProduct implements StockableInterface
{
    const VARIANT_PICKING_CHOICE = 0;
    const VARIANT_PICKING_MATCH  = 1;

    /**
     * Product category.
     *
     * @Assert\NotBlank
     *
     * @var CategoryInterface
     */
    protected $category;

    /**
     * Variant picking mode.
     * Whether to display a choice form with all variants or match variant for
     * given options.
     *
     * @var integer
     */
    protected $variantPickingMode;

    /**
     * Image path.
     *
     * @var string
     */
    protected $imagePath;

    /**
     * Image upload.
     *
     * @Assert\File(maxSize="512k")
     * @Assert\Image
     */
    public $image;

    /**
     * Set default variant picking mode.
     */
    public function __construct()
    {
        parent::__construct();

        $this->variantPickingMode = self::VARIANT_PICKING_CHOICE;
    }

    /**
     * Get category.
     *
     * @return CategoryInterface
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set category.
     *
     * @param CategoryInterface $category
     */
    public function setCategory(CategoryInterface $category)
    {
        $this->category = $category;
    }

    public function getVariantPickingMode()
    {
        return $this->variantPickingMode;
    }

    public function setVariantPickingMode($variantPickingMode)
    {
        if (!in_array($variantPickingMode, array(self::VARIANT_PICKING_CHOICE, self::VARIANT_PICKING_MATCH))) {
            throw new \InvalidArgumentException('Wrong variant picking mode supplied');
        }

        $this->variantPickingMode = $variantPickingMode;
    }

    public function isVariantPickingModeChoice()
    {
        return self::VARIANT_PICKING_CHOICE === $this->variantPickingMode;
    }

    /**
     * This is a proxy method to access master variant price.
     * Because if there are no options/variants defined, the master variant is
     * the project.
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->masterVariant->getPrice();
    }

    /**
     * Implementation of stockable interface.
     * Proxy to use master variant for managing inventory status.
     *
     * {@inheritdoc}
     */
    public function getStockableId()
    {
        return $this->masterVariant->getStockableId();
    }

    /**
     * {@inheritdoc}
     */
    public function isInStock()
    {
        return $this->masterVariant->inStock();
    }

    /**
     * {@inheritdoc}
     */
    public function getOnHand()
    {
        return $this->masterVariant->getOnHand();
    }

    /**
     * {@inheritdoc}
     */
    public function setOnHand($onHand)
    {
        $this->masterVariant->setOnHand($onHand);
    }

    public function getImagePath()
    {
        return $this->imagePath;
    }

    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;
    }

    public function getAbsoluteImagePath()
    {
        return null === $this->getImagePath() ? null : $this->getImageUploadRootDir().'/'.$this->getImagePath();
    }

    public function getImageWebPath()
    {
        return null === $this->getImagePath() ? null : $this->getImageUploadDir().'/'.$this->getImagePath();
    }

    public function getImageUploadDir()
    {
        return 'uploads/images';
    }

    public function hasImage()
    {
        return null !== $this->getImagePath();
    }

    public function saveImage()
    {
        if (null === $this->image) {

            return;
        }

        $this->setImagePath(uniqid().'.'.$this->image->guessExtension());
        $this->image->move($this->getImageUploadRootDir(), $this->getImagePath());
    }

    public function deleteImage()
    {
        if ($file = $this->getAbsoluteImagePath()) {
            unlink($file);
        }
    }

    protected function getImageUploadRootDir()
    {
        return __DIR__.'/../../../../../../public/'.$this->getImageUploadDir();
    }

    static public function getVariantPickingModeChoices()
    {
        return array(
            self::VARIANT_PICKING_CHOICE => 'Display list of variants',
            self::VARIANT_PICKING_MATCH  => 'Display options'
        );
    }

    /**
     * Get comment thread ID.
     *
     * @return string
     */
    public function getCommentThreadId()
    {
        return 'assortment_product_'.$this->getId();
    }
}
