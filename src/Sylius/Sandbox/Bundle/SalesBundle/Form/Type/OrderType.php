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

use Sylius\Bundle\SalesBundle\Form\Type\OrderType as BaseOrderType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Order form type.
 * Adds address to assign it to order.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class OrderType extends BaseOrderType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        switch ($options['mode']) {
            case self::MODE_CREATE:
            case self::MODE_UPDATE:
            case self::MODE_PLACE:
                $builder
                    ->add('deliveryAddress', 'sylius_addressing_address')
                    ->add('billingAddress', 'sylius_addressing_address')
                ;
            break;
        }
    }
}
