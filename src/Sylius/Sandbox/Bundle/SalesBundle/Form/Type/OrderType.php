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
use Symfony\Component\Form\FormBuilder;

/**
 * Order form type.
 * Adds address to assign it to order.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class OrderType extends BaseOrderType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('address', 'sylius_addressing_address')
        ;
    }
}
