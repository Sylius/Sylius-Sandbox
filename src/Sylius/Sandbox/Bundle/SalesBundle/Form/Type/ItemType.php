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

use Sylius\Bundle\SalesBundle\Form\Type\ItemType as BaseItemType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * Item form type.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class ItemType extends BaseItemType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $factory = $builder->getFormFactory();

        $listener = function (FormEvent $event) use ($factory) {
            $form = $event->getForm();
            $item = $event->getData();

            if (null === $item) {
                return;
            }

            $disabled = null !== $item->getId();

            $form
                ->remove('variant')
                ->add(
                    $factory->createNamed('variant', 'sylius_assortment_variant_to_identifier', $item->getVariant(), array(
                        'identifier' => 'sku',
                        'disabled'   => $disabled
                    ))
                )
            ;
        };

        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, $listener)
            ->add('variant', 'sylius_assortment_variant_to_identifier', array(
                'identifier' => 'sku'
            ))
        ;
    }
}
