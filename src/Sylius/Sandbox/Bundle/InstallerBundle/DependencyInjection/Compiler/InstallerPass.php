<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Sandbox\Bundle\InstallerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * Compiler pass that registers all setups.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class InstallerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if ('installer' == $container->getParameter('kernel.environment')) {
            $container->removeDefinition('sylius_theming.listener.request');
        }
    }
}
