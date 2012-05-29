<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Sandbox\Bundle\CartBundle\Provider;

use Sylius\Bundle\CartBundle\Provider\CartProvider as BaseCartProvider;

/**
 * Description of CartProvider.
 *
 * @author Саша Стаменковић <umpirsky@gmail.com>
 */
class CartProvider extends BaseCartProvider
{
    /**
     * {@inheritdoc}
     */
    protected function getCartByIdentifier($identifier)
    {
        return $this->cartManager->findCart($identifier);
    }
}
