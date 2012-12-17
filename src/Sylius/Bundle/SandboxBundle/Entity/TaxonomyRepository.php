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

use Sylius\Bundle\TaxonomiesBundle\Entity\TaxonomyRepository as BaseTaxonomyRepository;

/**
 * Taxonomy repository.
 *
 * @author Саша Стаменковић <umpirsky@gmail.com>
 */
class TaxonomyRepository extends BaseTaxonomyRepository
{
    /**
     * Finds a single taxonomy by name.
     * 
     * @param string $name
     * 
     * @return Taxonomy|null
     */
    public function findOneByName($name)
    {
        return $this
            ->getQueryBuilder()
            ->andWhere('root.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
