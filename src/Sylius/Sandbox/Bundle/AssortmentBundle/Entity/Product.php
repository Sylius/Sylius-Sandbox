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
    /**
     * Product category.
     *
     * @var CategoryInterface
     */
    protected $category;

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
}
