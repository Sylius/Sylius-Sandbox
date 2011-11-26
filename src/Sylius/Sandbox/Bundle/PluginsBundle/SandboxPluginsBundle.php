<?php

namespace Sylius\Sandbox\Bundle\PluginsBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SandboxPluginsBundle extends Bundle
{
    public function getParent()
    {
        return 'SyliusPluginsBundle';
    }    
}
