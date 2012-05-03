<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Sandbox\Bundle\AddressingBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Sandbox addressing bundle.
 * This bundle is implementation of SyliusAddressingBundle.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class SandboxAddressingBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'SyliusAddressingBundle';
    }
}
