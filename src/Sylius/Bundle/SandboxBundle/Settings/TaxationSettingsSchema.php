<?php

namespace Sylius\Bundle\SandboxBundle\Settings;

use Doctrine\Common\Persistence\ObjectRepository;
use Sylius\Bundle\AddressingBundle\Form\DataTransformer\ZoneToIdentifierTransformer;
use Sylius\Bundle\SettingsBundle\Schema\Schema;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Taxation settings schema.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class TaxationSettingsSchema extends Schema
{
    private $zoneRepository;

    public function __construct(ObjectRepository $zoneRepository)
    {
        $this->zoneRepository = $zoneRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function getDataTransformers()
    {
        return array(
            'defaultTaxZone' => new ZoneToIdentifierTransformer($this->zoneRepository, 'id')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function build(FormBuilderInterface $builder)
    {
        $builder
            ->add('defaultTaxZone', 'sylius_zone_choice', array(
                'label' => 'Default tax zone'
            ))
        ;
    }
}
