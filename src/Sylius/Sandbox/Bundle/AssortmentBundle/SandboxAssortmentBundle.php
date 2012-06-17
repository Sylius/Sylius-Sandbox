<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Sandbox\Bundle\AssortmentBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Sandbox assortment bundle.
 *
 * This is quite rich implementation of SyliusAssortmentBundle.
 * With a lot of extensions and integrations with other bundles.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class SandboxAssortmentBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'SyliusAssortmentBundle';
    }
}
