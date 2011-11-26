<?php

namespace Sylius\Plugin\JokerPlugin;

use Sylius\Plugin\JokerPlugin\DependencyInjection\SyliusJokerExtension;

use Sylius\Bundle\PluginsBundle\HttpKernel\Plugin\Plugin;

class SyliusJokerPlugin extends Plugin
{
    public function getContainerExtension()
    {
        return new SyliusJokerExtension();
    }
}
