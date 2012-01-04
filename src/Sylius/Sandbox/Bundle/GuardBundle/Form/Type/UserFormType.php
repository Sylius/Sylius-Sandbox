<?php

namespace Sylius\Sandbox\Bundle\GuardBundle\Form\Type;

use Symfony\Component\Form\FormBuilder;

use Sylius\Bundle\GuardBundle\Form\Type\UserFormType as BaseUserFormType;

class UserFormType extends BaseUserFormType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->remove('username');
    }
}
