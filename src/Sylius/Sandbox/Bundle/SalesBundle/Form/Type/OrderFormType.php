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

use Sylius\Sandbox\Bundle\SalesBundle\Entity\Order;
use Sylius\Bundle\SalesBundle\Form\Type\OrderFormType as BaseOrderFormType;
use Symfony\Component\Form\FormBuilder;

class OrderFormType extends BaseOrderFormType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('address', 'sylius_addressing_address')
        ;
    }
}
