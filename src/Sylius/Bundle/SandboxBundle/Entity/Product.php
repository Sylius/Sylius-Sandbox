<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\SandboxBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Bundle\AssortmentBundle\Entity\CustomizableProduct as BaseProduct;
use Sylius\Bundle\InventoryBundle\Model\StockableInterface;
use Sylius\Bundle\TaxationBundle\Model\TaxCategoryInterface;
use Sylius\Bundle\TaxationBundle\Model\TaxableInterface;
use Symfony\Component\Validator\Constraints as Assert;

class Product extends BaseProduct implements StockableInterface, TaxableInterface
{
    const VARIANT_PICKING_CHOICE = 0;
    const VARIANT_PICKING_MATCH  = 1;

    protected $taxCategory;
    protected $taxons;

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
     * @Assert\File(maxSize="1024k")
     * @Assert\Image
     */
    protected $image;

    /**
     * Is product available on demand?
     *
     * @var Boolean
     */
    protected $availableOnDemand;

    /**
     * Set default variant picking mode.
     */
    public function __construct()
    {
        parent::__construct();

        $this->variantPickingMode = self::VARIANT_PICKING_CHOICE;
        $this->availableOnDemand = true;
        $this->taxons = new ArrayCollection();

        $this->setMasterVariant(new Variant());
    }

    public function getTaxCategory()
    {
        return $this->taxCategory;
    }

    public function setTaxCategory(TaxCategoryInterface $taxCategory = null)
    {
        $this->taxCategory = $taxCategory;
    }

    public function getTaxons()
    {
        return $this->taxons;
    }

    public function setTaxons(Collection $taxons)
    {
        $this->taxons = $taxons;
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
        return $this
            ->getMasterVariant()
            ->getPrice()
        ;
    }

    /**
     * Implementation of stockable interface.
     * Proxy to use master variant for managing inventory status.
     *
     * {@inheritdoc}
     */
    public function getStockableId()
    {
        return $this
            ->getMasterVariant()
            ->getStockableId()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function isInStock()
    {
        return $this
            ->getMasterVariant()
            ->isInStock()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getOnHand()
    {
        return $this
            ->getMasterVariant()
            ->getOnHand()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setOnHand($onHand)
    {
        $this
            ->getMasterVariant()
            ->setOnHand($onHand)
        ;
    }

    public function getImagePath()
    {
        return $this->imagePath;
    }

    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
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
        return __DIR__.'/../../../../../public/'.$this->getImageUploadDir();
    }

    public static function getVariantPickingModeChoices()
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

    public function getInventoryName()
    {
        return $this->getName();
    }

    public function isAvailableOnDemand()
    {
        return $this->availableOnDemand;
    }

    public function setAvailableOnDemand($availableOnDemand)
    {
        $this->availableOnDemand = (Boolean) $availableOnDemand;
    }
}
