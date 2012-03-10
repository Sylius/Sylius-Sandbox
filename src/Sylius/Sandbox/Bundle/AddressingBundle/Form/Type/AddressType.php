<?php

/*
* This file is part of the Sylius sandbox application.
*
* (c) Paweł Jędrzejewski
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Sylius\Sandbox\Bundle\AddressingBundle\Form\Type;

use Symfony\Component\Form\FormBuilder;
use Sylius\Bundle\AddressingBundle\Form\Type\AddressType as BaseAddressType;

class AddressType extends BaseAddressType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('surname')
            ->add('street')
            ->add('city')
            ->add('postcode')
            ->add('email', 'email')
            ->add('phone', 'text', array('required' => false))
        ;
    }
}
