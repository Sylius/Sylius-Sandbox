<?php

/*
* This file is part of the Sylius sandbox application.
*
* (c) Paweł Jędrzejewski
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Sylius\Sandbox\Bundle\SalesBundle\Entity;

use Sylius\Bundle\AssortmentBundle\Model\Variant\VariantInterface;
use Sylius\Bundle\SalesBundle\Entity\OrderItem as BaseOrderItem;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Sales order entity.
 *
 * @author Paweł Jędrzjewski <pjedrzejewski@diweb.pl>
 */
class OrderItem extends BaseOrderItem
{
    /**
     * @Assert\NotBlank
     */
    protected $variant;

    public function getVariant()
    {
        return $this->variant;
    }

    public function setVariant(VariantInterface $variant)
    {
        $this->variant = $variant;
    }

}
