<?php

/*
* This file is part of the Sylius sandbox application.
*
* (c) Paweł Jędrzejewski
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Sylius\Sandbox\Bundle\SalesBundle\Form\Type;

use Sylius\Bundle\SalesBundle\Form\Type\ItemType as BaseItemType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Item form type.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class ItemType extends BaseItemType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('variant', 'sylius_assortment_variant_to_identifier', array('identifier' => 'sku'))
        ;
    }
}
