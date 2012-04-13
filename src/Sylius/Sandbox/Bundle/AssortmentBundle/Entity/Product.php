<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Sandbox\Bundle\AssortmentBundle\Entity;

use Sylius\Bundle\CategorizerBundle\Model\CategoryInterface;
use Sylius\Bundle\AssortmentBundle\Entity\CustomizableProduct as BaseProduct;

class Product extends BaseProduct
{
    protected $category;

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory(CategoryInterface $category)
    {
        $this->category = $category;
    }
}
