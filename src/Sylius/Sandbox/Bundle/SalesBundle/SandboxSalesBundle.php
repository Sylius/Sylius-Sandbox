<?php

namespace Sylius\Sandbox\Bundle\SalesBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SandboxSalesBundle extends Bundle
{
    public function getParent()
    {
        return 'SyliusSalesBundle';
    }
}
