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

use Sylius\Bundle\AssortmentBundle\Form\Type\CustomizableProductType as BaseCustomizableProductType;
use Sylius\Sandbox\Bundle\CoreBundle\Entity\Product;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Product form type.
 * Extends customizable form type, we just need to add category choice.
 *
 * Also we add a simple choice field to determine how product variants should
 * be selected, matched against combination of option or just list them all.
 *
 * @author Paweł Jędrzejewkski <pjedrzejewski@diweb.pl>
 */
class ProductType extends BaseCustomizableProductType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('image', 'file')
            ->add('category', 'sylius_categorizer_category_choice', array(
                'multiple' => false,
                'catalog'  => 'assortment'
            ))
            ->add('variantPickingMode', 'choice', array(
                'label'    => 'Variant picking mode',
                'choices'  => Product::getVariantPickingModeChoices()
            ))
        ;
    }
}
