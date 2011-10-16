<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Bundle\AssortmentBundle\Form\Type;

use Sylius\Bundle\AssortmentBundle\Form\Type\ProductFormType as BaseProductFormType;

use Symfony\Component\Form\FormBuilder;

class ProductFormType extends BaseProductFormType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder
            ->add('category', 'sylius_catalog_category_choice', array(
                'multiple' => false,
                'catalog_alias' => 'assortment'
            ));
    }
}
