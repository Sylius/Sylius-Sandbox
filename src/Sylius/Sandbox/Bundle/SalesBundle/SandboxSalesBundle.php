<?php

/*
* This file is part of the Sylius sandbox application.
*
* (c) Paweł Jędrzejewski
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Sylius\Sandbox\Bundle\SalesBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SandboxSalesBundle extends Bundle
{
    public function getParent()
    {
        return 'SyliusSalesBundle';
    }
}
