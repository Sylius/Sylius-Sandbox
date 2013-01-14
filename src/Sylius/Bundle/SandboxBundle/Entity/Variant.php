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

use Sylius\Bundle\AssortmentBundle\Entity\Variant\Variant as BaseVariant;
use Sylius\Bundle\InventoryBundle\Model\StockableInterface;
use Sylius\Bundle\ShippingBundle\Model\ShippableInterface;
use Sylius\Bundle\ShippingBundle\Model\ShippingCategoryInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Sandbox product variant entity.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class Variant extends BaseVariant implements StockableInterface, ShippableInterface
{
    protected $sku;

    /**
     * Variant price.
     *
     * @Assert\NotBlank
     *
     * @var float
     */
    protected $price;

    /**
     * On hand stock.
     *
     * @Assert\NotBlank
     * @Assert\Min(0)
     *
     * @var integer
     */
    protected $onHand;

    protected $shippingCategory;

    /**
     * Is variant available on demand?
     *
     * @var Boolean
     */
    protected $availableOnDemand;

    /**
     * Override constructor to set on hand stock.
     */
    public function __construct()
    {
        parent::__construct();

        $this->price = 0.00;
        $this->onHand = 1;
        $this->availableOnDemand = true;
    }

    public function getSku()
    {
        return $this->sku;
    }

    public function setSku($sku)
    {
        $this->sku = $sku;
    }

    /**
     * Get price.
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set price.
     *
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * {@inheritdoc}
     */
    public function isInStock()
    {
        return 0 < $this->onHand;
    }

    /**
     * {@inheritdoc}
     */
    public function getOnHand()
    {
        return $this->onHand;
    }

    /**
     * {@inheritdoc}
     */
    public function setOnHand($onHand)
    {
        $this->onHand = $onHand;

        if (0 > $this->onHand) {
            $this->onHand = 0;
        }
    }

    public function getInventoryName()
    {
        return $this->product->getName();
    }

    public function isAvailableOnDemand()
    {
        return $this->availableOnDemand;
    }

    public function setAvailableOnDemand($availableOnDemand)
    {
        $this->availableOnDemand = (Boolean) $availableOnDemand;
    }

    public function getShippingCategory()
    {
        if (null === $this->shippingCategory && !$this->isMaster() && null !== $product = $this->getProduct()) {
            return $product->getMasterVariant()->getShippingCategory();
        }

        return $this->shippingCategory;
    }

    public function setShippingCategory(ShippingCategoryInterface $category = null)
    {
        $this->shippingCategory = $category;
    }
}
