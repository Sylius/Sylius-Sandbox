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

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\FilterDataEvent;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Checkout addressing step form type.
 *
 * @author Paweł Jędrzejewkski <pjedrzejewski@diweb.pl>
 */
class CheckoutAddressingType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addEventListener(FormEvents::PRE_BIND, function (FilterDataEvent $event) {
                $data = $event->getData();
                $form = $event->getForm();

                if (!array_key_exists('differentBillingAddress', $data) || false === $data['differentBillingAddress']) {
                    $data['billingAddress'] = $data['deliveryAddress'];

                    $event->setData($data);
                }
            })
            ->add('deliveryAddress', 'sylius_address')
            ->add('billingAddress', 'sylius_address')
            ->add('differentBillingAddress', 'checkbox', array(
                'mapped' => false,
                'label'  => 'Use different address for billing?'
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'data_class' => null
            ))
        ;
    }

    public function getName()
    {
        return 'sylius_sandbox_checkout_addressing';
    }
}
