<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Sandbox\Bundle\AssortmentBundle\Form\Type;

use Sylius\Bundle\CatalogBundle\Form\Type\CategoryFormType as BaseCategoryFormType;

use Symfony\Component\Form\FormBuilder;

class CategoryFormType extends BaseCategoryFormType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder
            ->add('parent', 'sylius_catalog_category_choice', array(
                'required' => false,
                'multiple' => false,
                'catalog_alias' => 'assortment'
            ))
        ;
    }
}
