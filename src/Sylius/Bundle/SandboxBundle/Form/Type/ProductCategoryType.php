<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\SandboxBundle\Form\Type;

use Sylius\Bundle\CategorizerBundle\Form\Type\NestedCategoryType as BaseCategoryType;

/**
 * Simple class to create separate form type for assortment category.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class ProductCategoryType extends BaseCategoryType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sylius_sandbox_product_category';
    }
}
