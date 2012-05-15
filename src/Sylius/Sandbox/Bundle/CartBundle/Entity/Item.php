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

use Sylius\Bundle\AssortmentBundle\Model\Variant\VariantInterface;
use Sylius\Bundle\CartBundle\Entity\Item as BaseItem;
use Sylius\Bundle\CartBundle\Model\ItemInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Cart item entity.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class Item extends BaseItem
{
    /**
     * Variant.
     *
     * @Assert\NotBlank(groups={"CheckVariant"})
     *
     * @var VariantInterface
     */
    protected $variant;

    /**
     * Get associated variant.
     *
     * @return VariantInterface
     */
    public function getVariant()
    {
        return $this->variant;
    }

    /**
     * Set associated variant.
     *
     * @param VariantInterface $variant
     */
    public function setVariant(VariantInterface $variant)
    {
        $this->variant = $variant;
    }

    /**
     * {@inheritdoc}
     */
    public function equals(ItemInterface $item)
    {
        return $this->getVariant()->getId() === $item->getVariant()->getId();
    }
}
