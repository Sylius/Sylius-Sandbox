<?php

namespace Sylius\Sandbox\Bundle\CatalogBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SandboxCatalogBundle extends Bundle
{
    public function getParent()
    {
        return 'SyliusCatalogBundle';
    }    
}
