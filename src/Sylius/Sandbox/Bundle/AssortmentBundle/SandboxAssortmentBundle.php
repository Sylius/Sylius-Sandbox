<?php

namespace Sylius\Sandbox\Bundle\AssortmentBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SandboxAssortmentBundle extends Bundle
{
    public function getParent()
    {
        return 'SyliusAssortmentBundle';
    }    
}
