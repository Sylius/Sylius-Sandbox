<?php

namespace Sylius\Sandbox\Bundle\AssortmentBundle\Entity;

use Sylius\Bundle\CatalogBundle\Entity\Category as BaseCategory;

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
