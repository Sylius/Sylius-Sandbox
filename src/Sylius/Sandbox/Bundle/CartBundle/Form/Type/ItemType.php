<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Sandbox\Bundle\CartBundle\Form\Type;

use Sylius\Bundle\CartBundle\Form\Type\ItemType as BaseItemType;

use Symfony\Component\Form\FormBuilder;

class ItemType extends BaseItemType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder
            ->add('product', 'sylius_assortment_product_hidden');
    }
}
