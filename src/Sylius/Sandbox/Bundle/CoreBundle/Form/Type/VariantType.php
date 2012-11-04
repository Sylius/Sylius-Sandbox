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

use Sylius\Bundle\AssortmentBundle\Form\Type\VariantType as BaseVariantType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Product variant type. We need to add only simple price field and inventory tracking field for quantity.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class VariantType extends BaseVariantType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('price', 'number')
            ->add('onHand', 'integer', array(
                'label' => 'Stock "on hand"',
                'data'  => 0
            ))
        ;
    }
}
