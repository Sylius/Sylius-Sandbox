<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Sandbox\Bundle\CoreBundle\Entity\Variant;

use Sylius\Bundle\AssortmentBundle\Entity\Variant\Variant as BaseVariant;
use Sylius\Bundle\InventoryBundle\Model\StockableInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Sandbox product variant entity.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class Variant extends BaseVariant implements StockableInterface
{
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

    /**
     * Override constructor to set on hand stock.
     */
    public function __construct()
    {
        parent::__construct();

        $this->price = 0.00;
        $this->onHand = 1;
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
     * Implementation of stockable interface.
     * Uses Variant SKU as stocking id.
     *
     * {@inheritdoc}
     */
    public function getStockableId()
    {
        return $this->sku;
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
    }
}
