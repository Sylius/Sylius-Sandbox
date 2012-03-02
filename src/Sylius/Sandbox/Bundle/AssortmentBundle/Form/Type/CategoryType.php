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

use Sylius\Bundle\CategorizerBundle\Form\Type\CategoryType as BaseCategoryType;

use Symfony\Component\Form\FormBuilder;

class CategoryType extends BaseCategoryType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('parent', 'sylius_categorizer_category_choice', array(
                'required'      => false,
                'multiple'      => false,
                'catalog'       => 'assortment'
            ))
        ;
    }

    public function getName()
    {
        return 'sylius_sandbox_assortment_category';
    }
}
