<?php

/*
 * This file is part of the Sandbox.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Sandbox\Bundle\GuardBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Bundle\GuardBundle\Entity\User as BaseUser;

class User extends BaseUser
{
    public $acceptTermsOfUse = false;
    protected $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();

        parent::__construct();
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->setUsername($email);

        parent::setEmail($email);
    }

    public function getOrders()
    {
        return $this->orders;
    }

    public function setOrders($orders)
    {
        $this->orders = $orders;
    }
}
