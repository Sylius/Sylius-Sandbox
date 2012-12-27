<?php

namespace Sylius\Bundle\SandboxBundle\Settings;

use Sylius\Bundle\SettingsBundle\Schema\SchemaInterface;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Example sandbox checkout process.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class GeneralSettingsSchema implements SchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function getNamespace()
    {
        return 'general';
    }

    /**
     * {@inheritdoc}
     */
    public function build(FormBuilderInterface $builder)
    {
        $builder
            ->add('siteName', 'text', array(
                'label' => 'Site name'
            ))
            ->add('siteUrl', 'textarea', array(
                'label' => 'Site URL'
            ))
            ->add('defaultMetaTitle', 'text', array(
                'label' => 'Default meta title'
            ))
            ->add('defaultMetaKeywords', 'text', array(
                'label' => 'Default meta keywords'
            ))
            ->add('defaultMetaDescription', 'textarea', array(
                'label' => 'Default meta description'
            ))
        ;
    }
}
