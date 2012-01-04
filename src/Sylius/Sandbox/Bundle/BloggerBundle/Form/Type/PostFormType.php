<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Sandbox\Bundle\BloggerBundle\Form\Type;

use Sylius\Bundle\BloggerBundle\Form\Type\PostFormType as BasePostFormType;
use Symfony\Component\Form\FormBuilder;

class PostFormType extends BasePostFormType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('categories', 'sylius_catalog_category_choice', array(
                'multiple' => true,
                'catalog_alias' => 'blog'
            ))
        ;
    }
}
