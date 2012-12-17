<?php

namespace Sylius\Behat;

use Behat\Behat\Context\Step;
use Behat\Gherkin\Node\TableNode;

/**
 * Moving around page context.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class PagesContext extends BaseContext
{
    /**
     * @Given /^I am on store homepage$/
     */
    public function iAmOnStoreHomepage()
    {
        return $this->iAmOnRoute('sylius_sandbox_core_frontend');
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
     * @Then /^I should be on store homepage$/
     */
    public function iShouldBeOnStoreHomepage()
    {
        return $this->iShouldBeOnRoute('sylius_sandbox_core_frontend');
    }

    /**
     * @Then /^I should be on login page$/
     */
    public function iShouldBeOnLoginPage()
    {
        return $this->iShouldBeOnRoute('fos_user_security_login');
    }

    /**
     * @Then /^I should be on registration page$/
     */
    public function iShouldBeOnRegistrationPage()
    {
        return $this->iShouldBeOnRoute('fos_user_registration_register');
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

    private function iAmOnRoute($route, array $parameters = array())
    {
        return $this->iAmOn($this->generateUrl($route, $parameters));
    }

    private function iAmOn($path)
    {
        return new Step\Given(sprintf('I am on "%s"', $path));
    }

    private function iShouldBeOnRoute($route, array $parameters = array())
    {
        return $this->iShouldBeOn($this->generateUrl($route, $parameters));
    }

    private function iShouldBeOn($path)
    {
        return new Step\Given(sprintf('I should be on "%s"', $path));
    }
}
