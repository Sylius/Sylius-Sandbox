<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\SandboxBundle\EventListener;

use Doctrine\Common\Persistence\ObjectRepository;
use Sylius\Bundle\SandboxBundle\Entity\Order;
use Sylius\Bundle\ShippingBundle\Calculator\CalculatorInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * This listener calculates the shipping charge
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class OrderShippingListener
{
    /**
     * Adjustment repository.
     *
     * @var ObjectRepository
     */
    private $adjustmentRepository;

    /**
     * Shipping charges calculator.
     *
     * @var ShippingChargeCalculator
     */
    private $calculator;

    /**
     * Constructor.
     *
     * @param ObjectRepository    $adjustmentRepository
     * @param CalculatorInterface $calculator
     */
    public function __construct(ObjectRepository $adjustmentRepository, CalculatorInterface $calculator)
    {
        $this->adjustmentRepository = $adjustmentRepository;
        $this->calculator = $calculator;
    }

    /**
     * Calculate shipment charges on the order.
     *
     * @param GenericEvent $event
     */
    public function processShippingCharges(GenericEvent $event)
    {
        $order = $event->getSubject();

        foreach ($order->getShipments() as $shipment) {
            $adjustment = $this->adjustmentRepository->createNew();

            $charge = $this->calculator->calculate($shipment);

            $adjustment->setLabel(Order::SHIPPING_ADJUSTMENT);
            $adjustment->setAmount($charge);
            $adjustment->setDescription($shipment->getMethod()->getName());

            $order->addAdjustment($adjustment);
        }

        $order->calculateTotal();
    }
}
