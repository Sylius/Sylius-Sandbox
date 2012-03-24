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
        $toolbar = array(
            array(
                'name' => 'basicstyles',
                'items' => array('Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat')
            ),
            array(
                'name' => 'paragraph',
                'items' => array('NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock')
            ),
            array(
                'name' => 'links',
                'items' => array('Link', 'Unlink', 'Anchor')
            ),
            array(
                'name' => 'styles',
                'items' => array('Styles', 'Format', 'Font', 'FontSize')
            )
        );

        $builder
            ->add('name', 'text')
            ->add('description', 'ckeditor', array('toolbar' => $toolbar))
            ->add('price', 'money')
            ->add('category', 'sylius_categorizer_category_choice', array(
                'multiple' => false,
                'catalog'  => 'assortment'
            ))
        ;
    }
}
