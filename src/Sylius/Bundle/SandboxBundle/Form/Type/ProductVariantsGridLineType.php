<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\SandboxBundle\Form\Type;

use Sylius\Bundle\AssortmentBundle\Form\Type\VariantType as BaseVariantType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Product variant line for simple grid form.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class ProductVariantsGridLineType extends BaseVariantType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sku', 'text')
            ->add('price', 'money')
            ->add('onHand', 'integer', array(
                'label' => 'Stock "on hand"'
            ))
            ->add('availableOnDemand', 'checkbox', array(
                'label' => 'Available on demand'
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sylius_sandbox_product_variants_grid_line';
    }
}
