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

use Sylius\Bundle\AssortmentBundle\Form\Type\ProductType as BaseProductType;
use Symfony\Component\Form\FormBuilder;

class ProductType extends BaseProductType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('description', 'ckeditor')
            ->add('price', 'money')
            ->add('category', 'sylius_categorizer_category_choice', array(
                'multiple' => false,
                'catalog'  => 'assortment'
            ))
        ;
    }
}
