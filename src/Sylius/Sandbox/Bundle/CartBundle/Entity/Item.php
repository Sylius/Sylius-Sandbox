<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Sandbox\Bundle\CartBundle\Entity;

use Sylius\Bundle\AssortmentBundle\Model\ProductInterface;
use Sylius\Bundle\CartBundle\Entity\Item as BaseItem;

class Item extends BaseItem
{
    protected $product;

    public function getProduct()
    {
        return $this->product;
    }

    public function setProduct(ProductInterface $product)
    {
        $this->product = $product;
    }
}
