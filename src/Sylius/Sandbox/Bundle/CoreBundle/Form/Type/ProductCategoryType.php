<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Sandbox\Bundle\CoreBundle\Form\Type;

use Sylius\Bundle\CategorizerBundle\Form\Type\NestedCategoryType as BaseCategoryType;
use Symfony\Component\Form\FormBuilder;

/**
 * Simple class to create separate form type for assortment category.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class NestedCategoryType extends BaseCategoryType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sylius_sandbox_assortment_category';
    }
}
