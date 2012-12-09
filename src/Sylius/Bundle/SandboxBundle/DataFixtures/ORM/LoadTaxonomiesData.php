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

/**
 * Default taxonomies to play with.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class LoadTaxonomiesData extends DataFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->createTaxonomy('Category', array(
            'T-Shirts', 'Stickers', 'Mugs', 'Books'
        ));
        $this->createTaxonomy('Brand', array(
            'SuperTees', 'Stickypicky', 'Mugland', 'Bookmania'
        ));

        $this
            ->getTaxonomyManager()
            ->flush()
        ;
    }

    /**
     * Create and save taxonomy with given taxons.
     *
     * @param string $name
     * @param array  $taxons
     */
    private function createTaxonomy($name, array $taxons)
    {
        $taxonomy = $this
            ->getTaxonomyRepository()
            ->createNew()
        ;

        $taxonomy->setName($name);

        foreach ($taxons as $taxonName) {
            $taxon = $this
                ->getTaxonRepository()
                ->createNew()
            ;

            $taxon->setName($taxonName);

            $taxonomy->addTaxon($taxon);
            $this->setReference('Taxon.'.$taxonName, $taxon);
        }

        $this
            ->getTaxonomyManager()
            ->persist($taxonomy)
        ;

        $this->setReference('Taxonomy.'.$name, $taxonomy);
    }

    public function getOrder()
    {
        return 5;
    }

    private function getTaxonomyManager()
    {
        return $this->get('sylius_taxonomies.manager.taxonomy');
    }

    private function getTaxonomyRepository()
    {
        return $this->get('sylius_taxonomies.repository.taxonomy');
    }

    private function getTaxonRepository()
    {
        return $this->get('sylius_taxonomies.repository.taxon');
    }
}
