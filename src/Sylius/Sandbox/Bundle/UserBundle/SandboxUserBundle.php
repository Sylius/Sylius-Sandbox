<?php

/*
* This file is part of the Sylius sandbox application.
*
* (c) Paweł Jędrzejewski
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Sylius\Sandbox\Bundle\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * User sandbox bundle.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class SandboxUserBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
