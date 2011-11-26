<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Plugin\JokerPlugin\EventDispatcher\Listener;

use Sylius\Bundle\AssortmentBundle\EventDispatcher\Event\FilterProductEvent;

class JokerListener
{
    public function makeJoke(FilterProductEvent $event)
    {
        $product = $event->getProduct();
        
        // Yeah i know it is very funny indeed, but hey! It is just example...
        $product->setName(strrev($product->getName()) . ' Joker was here.');
    }
}
