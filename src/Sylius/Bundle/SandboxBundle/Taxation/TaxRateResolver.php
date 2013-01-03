<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\SandboxBundle\Taxation;

use Sylius\Bundle\TaxationBundle\Model\TaxableInterface;
use Sylius\Bundle\TaxationBundle\Resolver\TaxRateResolver as BaseTaxRateResolver;

/**
 * Default tax rate resolver.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@sylius.pl>
 */
class TaxRateResolver extends BaseTaxRateResolver
{
    /**
     * {@inheritdoc}
     */
    public function resolve(TaxableInterface $taxable, array $context = array())
    {
        if (null === $category = $taxable->getTaxCategory()) {
            return;
        }

        $zone = $context['zone'];

        return $this->taxRateRepository->findOneBy(array(
            'category' => $category,
            'zone'     => $zone
        ));
    }
}

