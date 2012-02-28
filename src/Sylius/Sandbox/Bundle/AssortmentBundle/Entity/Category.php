<?php

namespace Sylius\Sandbox\Bundle\AssortmentBundle\Entity;

use Sylius\Bundle\CategorizerBundle\Entity\NestedCategory as BaseCategory;

class Category extends BaseCategory
{
    protected $products;

    public function getProducts($products)
    {
        return $this->products;
    }

    public function setProducts($products)
    {
        $this->products = $products;
    }
}
