<?php

namespace Sylius\Sandbox\Bundle\ThemingBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SandboxThemingBundle extends Bundle
{
    public function getParent()
    {
        return 'SyliusThemingBundle';
    }
}
