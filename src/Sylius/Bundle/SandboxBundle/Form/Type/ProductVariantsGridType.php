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

use Sylius\Bundle\AssortmentBundle\Form\Type\CustomizableProductType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Handy form for editing all product variants at once.
 *
 * @author Paweł Jędrzejewkski <pjedrzejewski@diweb.pl>
 */
class ProductVariantsGridType extends CustomizableProductType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('variants', 'collection', array(
                'type' => 'sylius_sandbox_product_variants_grid_line'
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sylius_sandbox_product_variants_grid';
    }
}
