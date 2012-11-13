<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Sandbox\Bundle\CoreBundle\Entity;

use Sylius\Bundle\AddressingBundle\Entity\CommonAddress as BaseAddress;

/**
 * Empty address entity that extends the common address model from bundle.
 * No more work here, unless you want to customize the address.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class Address extends BaseAddress
{
}
