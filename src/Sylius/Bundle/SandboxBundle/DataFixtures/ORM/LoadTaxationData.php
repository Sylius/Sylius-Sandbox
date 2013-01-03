<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\SandboxBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Sylius\Bundle\TaxationBundle\Model\TaxCategoryInterface;

/**
 * Default taxation configuration.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class LoadTaxationData extends DataFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $taxableGoods = $this->createTaxCategory('Taxable goods', 'Default taxation category', 'Default');
        $this->createTaxRate($taxableGoods, 'Default Tax', 0.23, 'EU + USA GMT-8');
        $this->createTaxRate($taxableGoods, 'EU VAT', 0.23, 'EU');

        $clothing = $this->createTaxCategory('Clothing', 'All clothing goods', 'Clothing');
        $this->createTaxRate($clothing, 'Clothing US Tax', 0.20, 'USA GMT-8');
        $this->createTaxRate($clothing, 'Clothing EU Tax', 0.23, 'EU', true);

        $manager->flush();
    }

    private function createTaxCategory($name, $description, $referenceName)
    {
        $category = $this
            ->getTaxCategoryRepository()
            ->createNew()
        ;

        $category->setName($name);
        $category->setDescription($description);

        $this
            ->getTaxCategoryManager()
            ->persist($category)
        ;

        $this->setReference('TaxCategory.'.$referenceName, $category);

        return $category;
    }

    /**
     * Create tax rate.
     *
     * @param TaxCategoryInterface $category
     * @param string               $name
     * @param float                $amount
     * @param string               $zone
     * @param string               $calculator
     */
    private function createTaxRate(TaxCategoryInterface $category, $name, $amount, $zone, $includedInPrice = false, $calculator = 'default')
    {
        $rate = $this
            ->getTaxRateRepository()
            ->createNew()
        ;

        $rate->setCategory($category);
        $rate->setZone($this->getZone($zone));
        $rate->setName($name);
        $rate->setAmount($amount);
        $rate->setIncludedInPrice($includedInPrice);
        $rate->setCalculator($calculator);

        $this
            ->getTaxRateManager()
            ->persist($rate)
        ;

        $this->setReference('TaxRate.'.$name, $rate);
    }

    public function getOrder()
    {
        return 4;
    }

    private function getZone($name)
    {
        return $this->getReference('Zone-'.$name);
    }

    private function getTaxCategoryManager()
    {
        return $this->get('sylius_taxation.manager.category');
    }


    private function getTaxCategoryRepository()
    {
        return $this->get('sylius_taxation.repository.category');
    }

    private function getTaxRateManager()
    {
        return $this->get('sylius_taxation.manager.rate');
    }

    private function getTaxRateRepository()
    {
        return $this->get('sylius_taxation.repository.rate');
    }
}
