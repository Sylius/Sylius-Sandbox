<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Sandbox\Bundle\CartBundle\Entity;

use Sylius\Bundle\CartBundle\Entity\CartManager as BaseCartManager;

/**
 * Cart manager.
 *
 * @author Саша Стаменковић <umpirsky@gmail.com>
 */
class CartManager extends BaseCartManager
{
    /**
     * Optimizes cart loading.
     *
     * {@inheritdoc}
     */
    public function findCart($id)
    {
        return $this->repository->createQueryBuilder('cart')
            ->select('cart, item, variant, product', 'optionValue', 'option')
            ->leftJoin('cart.items', 'item')
            ->leftJoin('item.variant', 'variant')
            ->leftJoin('variant.product', 'product')
            ->leftJoin('variant.options', 'optionValue')
            ->leftJoin('optionValue.option', 'option')
            ->where('cart.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
