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

use Sylius\Bundle\AssortmentBundle\Model\ProductInterface;
use Sylius\Bundle\CartBundle\Form\Type\ItemType as BaseItemType;
use Symfony\Component\Form\Exception\FormException;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\OptionsResolver\Options;

/**
 * We extend the item form type a bit, to add a variant select field
 * when we're adding product to cart, but not when we edit quantity in cart.
 * We'll use simple option for that, passing the product instance required by
 * variant choice type.
 *
 * @author Paweł Jędrzejewkski <pjedrzejewski@diweb.pl>
 */
class ItemType extends BaseItemType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        parent::buildForm($builder, $options);

        if (isset($options['product'])) {
            if (!$options['product'] instanceof ProductInterface) {
                throw new FormException('Option "product" passed to cart item type must implement "Sylius\Bundle\AssortmentBundle\Model\ProductInterface"');
            }

            if (0 < $options['product']->countVariants()) {
                $type = $options['product']->isVariantPickingModeChoice() ? 'sylius_assortment_variant_choice' : 'sylius_assortment_variant_match';
                $builder->add('variant', $type, array(
                    'product'  => $options['product']
                ));
            }
        }
    }

    /**
     * We need to override this method to allow setting 'product'
     * option, by default it will be null so we don't get the variant choice
     * when creating full cart form.
     *
     * {@inheritdoc}
     */
    public function getDefaultOptions()
    {
        $defaultOptions = parent::getDefaultOptions();
        $defaultOptions['product'] = null;

        $defaultOptions['validation_groups'] = function (Options $options) {
            if (isset($options['product'])) {
                return 0 < $options['product']->countVariants() ? 'CheckVariant' : null;
            }
        };

        return $defaultOptions;
    }
}
