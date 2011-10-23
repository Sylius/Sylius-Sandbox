<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Bundle\CartBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Bundle\CartBundle\Entity\Cart as BaseCart;

class Cart extends BaseCart
{
    protected $value;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->value = 0.00;
    }
    
    public function getValue()
    {
        return $this->value;
    }
    
    public function setValue($value)
    {
        $this->value = $value;
    }
}
