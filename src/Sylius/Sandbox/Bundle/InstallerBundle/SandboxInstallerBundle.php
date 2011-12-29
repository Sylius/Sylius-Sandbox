<?php

namespace Sylius\Sandbox\Bundle\InstallerBundle;

use Sylius\Sandbox\Bundle\InstallerBundle\DependencyInjection\Compiler\InstallerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SandboxInstallerBundle extends Bundle
{
    public function build(ContainerBuilder $builder)
    {
        $builder->addCompilerPass(new InstallerPass());
    }
}
