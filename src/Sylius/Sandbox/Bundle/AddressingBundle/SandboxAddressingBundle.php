<?php

/*
 * This file is part of the Application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Sandbox\Bundle\AddressingBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SandboxAddressingBundle extends Bundle
{
    public function getParent()
    {
        return 'SyliusAddressingBundle';
    }    
}
