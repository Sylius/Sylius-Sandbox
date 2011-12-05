<?php

namespace Sylius\Sandbox\Bundle\InstallerBundle\Setup;

use Sylius\Sandbox\Bundle\InstallerBundle\Setup\Step\SecondStep;

use Sylius\Sandbox\Bundle\InstallerBundle\Setup\Step\FirstStep;

use Sylius\Bundle\InstallerBundle\Setup\Builder\SetupBuilderInterface;
use Sylius\Bundle\InstallerBundle\Setup\Setup as BaseSetup;

class Setup extends BaseSetup
{
    public function build(SetupBuilderInterface $builder, array $options)
    {
        $builder
            ->addStep(new FirstStep())
            ->addStep(new SecondStep())
        ;
    }
}