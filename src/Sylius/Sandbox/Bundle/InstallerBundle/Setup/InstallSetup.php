<?php

namespace Sylius\Sandbox\Bundle\InstallerBundle\Setup;

use Sylius\Sandbox\Bundle\InstallerBundle\Setup\Step\DoctrineStep;
use Sylius\Sandbox\Bundle\InstallerBundle\Setup\Step\ConfigurationStep;
use Sylius\Sandbox\Bundle\InstallerBundle\Setup\Step\PreconditionsStep;
use Sylius\Sandbox\Bundle\InstallerBundle\Setup\Step\LicenseStep;
use Sylius\Bundle\InstallerBundle\Setup\Builder\SetupBuilderInterface;
use Sylius\Bundle\InstallerBundle\Setup\Setup as BaseSetup;

class InstallSetup extends BaseSetup
{
    public function build(SetupBuilderInterface $builder, array $options)
    {
        $builder
            ->addStep(new LicenseStep())
            ->addStep(new PreconditionsStep())
            ->addStep(new ConfigurationStep())
            ->addStep(new DoctrineStep())
        ;
    }
}