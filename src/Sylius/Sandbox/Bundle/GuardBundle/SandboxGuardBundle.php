<?php

/*
 * This file is part of the Sandbox.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Sandbox\Bundle\GuardBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SandboxGuardBundle extends Bundle
{
    public function getParent()
    {
        return 'SyliusGuardBundle';
    }
}
