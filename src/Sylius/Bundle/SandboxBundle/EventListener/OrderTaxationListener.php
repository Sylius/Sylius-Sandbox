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
use Sylius\Bundle\AddressingBundle\Matcher\ZoneMatcherInterface;
use Sylius\Bundle\SalesBundle\Model\OrderInterface;
use Sylius\Bundle\SandboxBundle\Entity\Order;
use Sylius\Bundle\SettingsBundle\Manager\SettingsManagerInterface;
use Sylius\Bundle\TaxationBundle\Calculator\CalculatorInterface;
use Sylius\Bundle\TaxationBundle\Resolver\TaxRateResolverInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * Order taxation listener.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class OrderTaxationListener
{
    /**
     * Zone matcher.
     *
     * @var ZoneMatcherInterface
     */
    private $zoneMatcher;

    /**
     * Tax rate resolver.
     *
     * @var TaxRateResolverInterface
     */
    private $taxRateResolver;

    /**
     * Tax calculator.
     *
     * @var CalculatorInterface
     */
    private $taxCalculator;

    /**
     * Adjustment repository.
     *
     * @var ObjectRepository
     */
    private $adjustmentRepository;

    /**
     * Constructor.
     *
     * @param ZoneMatcherInterface     $zoneMatcher
     * @param TaxRateResolverInterface $taxRateResolver
     * @param CalculatorInterface      $taxCalculator
     * @param ObjectRepository         $adjustmentRepository
     * @param SettingsManagerInterface $settingsManager
     */
    public function __construct(
        ZoneMatcherInterface $zoneMatcher,
        TaxRateResolverInterface $taxRateResolver,
        CalculatorInterface $taxCalculator,
        ObjectRepository $adjustmentRepository,
        SettingsManagerInterface $settingsManager
    )
    {
        $this->zoneMatcher = $zoneMatcher;
        $this->taxRateResolver = $taxRateResolver;
        $this->taxCalculator = $taxCalculator;
        $this->adjustmentRepository = $adjustmentRepository;
        $this->settingsManager = $settingsManager;
    }

    /**
     * Determine taxes.
     *
     * @param FilterProductEvent $event
     */
    public function processTaxes(GenericEvent $event)
    {
        $order = $event->getSubject();
        $order->removeTaxAdjustments(); // Remove all tax adjustments, we recalculate everything from scratch.

        $zone = $this->zoneMatcher->match($order->getDeliveryAddress());

        if (null === $zone) {
            $zone = $this->getDefaultTaxZone();
        }

        $taxes = array();

        foreach ($order->getItems() as $item) {
            $taxable = $item->getVariant()->getProduct();
            $rate = $this->taxRateResolver->resolve($taxable, array('zone' => $zone));

            if (null === $rate) {
                continue;
            }

            $rateName = $rate->getName();

            $item->calculateTotal();

            $amount = $this->taxCalculator->calculate($item->getTotal(), $rate);
            $taxAmount = $rate->getAmount() * 100;
            $description = sprintf('%s (%d%%)', $rateName, $taxAmount);

            if (!array_key_exists($description, $taxes)) {
                $taxes[$description] = 0;
            }

            $taxes[$description] += $taxAmount;
        }

        foreach ($taxes as $description => $amount) {
            $adjustment = $this->adjustmentRepository->createNew();

            $adjustment->setLabel(Order::TAX_ADJUSTMENT);
            $adjustment->setDescription($description);
            $adjustment->setAmount($amount);

            $order->addAdjustment($adjustment);
        }

        $order->calculateTotal();
    }

    /**
     * Get the default tax zone.
     *
     * @return ZoneInterface
     */
    private function getDefaultTaxZone()
    {
        $taxationSettings = $this->settingsManager->loadSettings('taxation');

        return $taxationSettings['defaultTaxZone'];
    }
}
