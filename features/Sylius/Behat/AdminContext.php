<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Behat;

use Behat\Mink\Exception\ElementNotFoundException;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Context\Step;

/**
 * Administrator context.
 *
 * @author Саша Стаменковић <umpirsky@gmail.com>
 */
class AdminContext extends BaseContext
{
    /**
     * @Given /^I follow edit taxonomy "([^"]*)"$/
     */
    public function iFollowEditTaxonomy($taxonomy)
    {
        $this->iFollowTaxonomyLink($taxonomy, 'a:contains("edit")');
    }

    /**
     * @Given /^I follow delete taxonomy "([^"]*)"$/
     */
    public function iFollowDeleteTaxonomy($taxonomy)
    {
        $this->iFollowTaxonomyLink($taxonomy, 'a[title="delete"]');
    }

    /**
     * @Given /^I follow browse "([^"]*)" products$/
     */
    public function iFollowBrowseTaxonProducts($taxon)
    {
        $this->iFollowTaxonLink($taxon, 'a:contains("browse products")');
    }

    /**
     * @Given /^I follow edit taxon "([^"]*)"$/
     */
    public function iFollowEditTaxon($taxon)
    {
        $this->iFollowTaxonLink($taxon, 'a:contains("edit")');
    }

    /**
     * @Given /^I follow delete taxon "([^"]*)"$/
     */
    public function iFollowDeleteTaxon($taxon)
    {
        $this->iFollowTaxonLink($taxon, 'a[title="delete"]');
    }

    /**
     * @Given /^I am on dashboard$/
     */
    public function iAmOnDashboard()
    {
        return $this->iAmOnRoute('sylius_sandbox_core_backend');
    }

    /**
     * @Given /^I am on list taxonimies$/
     */
    public function iAmOnListTaxonomies()
    {
        return $this->iAmOnRoute('sylius_sandbox_backend_taxonomy_list');
    }

    /**
     * @Given /^I am on create taxonomy$/
     */
    public function iAmOnCreateTaxonomy()
    {
        return $this->iAmOnRoute('sylius_sandbox_backend_taxonomy_create');
    }

    /**
     * @Given /^I am on browse "([^"]*)" taxon products$/
     */
    public function iAmOnBrowseTaxonProducts($permalink)
    {
        return $this->iAmOnRoute('sylius_sandbox_backend_product_list_by_taxon', array('permalink' => $permalink));
    }

    /**
     * @Given /^I am on create taxon$/
     */
    public function iAmOnCreateTaxon()
    {
        return $this->iAmOnRoute('sylius_sandbox_backend_taxon_create');
    }

    /**
     * @Given /^I am logged in as admin$/
     */
    public function iAmLoggedInAsAdmin()
    {
        $table = new TableNode(<<<TABLE
| username | password | role              |
| admin    | foo      | ROLE_SYLIUS_ADMIN |
TABLE
        );

        return array(
            new Step\Given('there are following users:', $table),
            new Step\When('I am on "/login"'),
            new Step\When('I fill in "Login" with "admin"'),
            new Step\When('I fill in "Password" with "foo"'),
            new Step\When('I press "login"'),
        );
    }

    /**
     * @Then /^I should be on create taxonomy$/
     */
    public function iShouldBeOnCreateTaxonomy()
    {
        return $this->iShouldBeOnRoute('sylius_sandbox_backend_taxonomy_create');
    }

    /**
     * @Then /^I should be on update taxonomy "([^"]*)"$/
     */
    public function iShouldBeOnUpdateTaxonomy($taxonomy)
    {
        $id = $this
            ->getService('sylius_taxonomies.repository.taxonomy')
            ->findOneByName($taxonomy)
            ->getId()
        ;

        return $this->iShouldBeOnRoute(
            'sylius_sandbox_backend_taxonomy_update', array('id' => $id)
        );
    }

    /**
     * @Then /^I should be on list taxonomies$/
     */
    public function iShouldBeOnListTaxonomies()
    {
        return $this->iShouldBeOnRoute('sylius_sandbox_backend_taxonomy_list');
    }

    /**
     * @Then /^I should be on create taxon$/
     */
    public function iShouldBeOnCreateTaxon()
    {
        return $this->iShouldBeOnRoute('sylius_sandbox_backend_taxon_create');
    }

    /**
     * @Then /^I should be on update taxon "([^"]*)"$/
     */
    public function iShouldBeOnUpdateTaxon($taxon)
    {
        $id = $this
            ->getService('sylius_taxonomies.repository.taxon')
            ->findOneBy(array('name' => $taxon))
            ->getId()
        ;

        return $this->iShouldBeOnRoute(
            'sylius_sandbox_backend_taxon_update', array('id' => $id)
        );
    }

    /**
     * Follows taxonomy action from taxonomies list table.
     *
     * @param string $taxonomy taxonomy name
     * @param string $selector css selector to find link to follow
     */
    private function iFollowTaxonomyLink($taxonomy, $selector)
    {
        $taxonomyCells = $this->getActualValuesInTableByColumnName('taxonomies-list', 'name');
        foreach ($taxonomyCells as $row => $taxonomyCell) {
            if ($taxonomyCell->getText() === $taxonomy) {
                $actionCells = $this->getActualValuesInTableByColumnName('taxonomies-list', '');

                return $this->getSession()->visit(
                    $actionCells[$row]->find('css', $selector)->getAttribute('href')
                );
            }
        }

        throw new ElementNotFoundException(
            $this->getSession(), 'a', 'css', $selector
        );

    }

    /**
     * Follows taxon action from taxonomies list table.
     *
     * @param string $taxon taxon name
     * @param string $selector css selector to find link to follow
     */
    private function iFollowTaxonLink($taxon, $selector)
    {
        $taxonCells = $this->getActualValuesInTableByColumnName('taxonomies-list', 'taxons');
        foreach ($taxonCells as $row => $taxonCell) {
            $taxonDiv = $taxonCell->find('css', sprintf('div:contains("%s")', $taxon));
            if (null !== $taxonDiv) {
                return $this->getSession()->visit($taxonDiv->find('css', $selector)->getAttribute('href'));
            }
        }

        throw new ElementNotFoundException(
            $this->getSession(), 'a', 'css', $selector
        );

    }

    /**
     * Fetch all the values of a column inside a table.
     *
     * @param string $id     css id of the the table to fetch from
     * @param string $column column index from where we're getting the values
     *
     * @return \Behat\Mink\Element\NodeElement[]
     */
    private function getActualValuesInTable($id, $column)
    {
        $rows = $this->getSession()->getPage()->findAll('css', sprintf('table#%s tbody tr', $id));

        $values = array();
        foreach ($rows as $row) {
            $cols = $row->findAll('css', 'td');
            $values[] = $cols[$column];
        }

        return $values;
    }

    /**
     * Fetch all the values of a column inside a table.
     *
     * @param string $id         css id of the the table to fetch from
     * @param string $columnName name of the column from where we're getting the values
     *
     * @return \Behat\Mink\Element\NodeElement[]
     */
    private function getActualValuesInTableByColumnName($id, $columnName)
    {
        $selector = sprintf('table#%s thead tr th', $id);
        $rows = $this->getSession()->getPage()->findAll('css', $selector);

        foreach ($rows as $key => $row) {
            if ($row->getText() === $columnName) {
                return $this->getActualValuesInTable($id, $key);
            }
        }

        throw new ElementNotFoundException(
            $this->getSession(), 'table element', 'css', $selector
        );
    }
}
