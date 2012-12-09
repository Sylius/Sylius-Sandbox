<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\SandboxBundle\Entity;

use Sylius\Bundle\TaxonomiesBundle\Entity\Taxonomy as BaseTaxonomy;

/**
 * Taxonomy entity.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class Taxonomy extends BaseTaxonomy
{
    public function __construct()
    {
        parent::__construct();

        $this->root = new Taxon();
    }
}
