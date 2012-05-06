<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Sandbox\Bundle\AssortmentBundle\EventDispatcher\Listener;

use Sylius\Bundle\AssortmentBundle\EventDispatcher\Event\FilterProductEvent;
use Sylius\Bundle\StockingBundle\Operator\StockOperatorInterface;

/**
 * Stock listener.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class StockingListener
{
    /**
     * Stock operator.
     *
     * @var StockOperatorInterface
     */
    private $stockOperator;

    /**
     * Constructor.
     *
     * @param StockOperatorInterface $stockOperator
     */
    public function __construct(StockOperatorInterface $stockOperator)
    {
        $this->stockOperator = $stockOperator;
    }

    /**
     * Refresh product stock.
     *
     * @param FilterProductEvent $event
     */
    public function refreshProductStock(FilterProductEvent $event)
    {
        $this->stockOperator->refresh($event->getProduct());
    }
}
