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
     * @Given /^I am on admin dashboard$/
     */
    public function iAmOnAdminDashboard()
    {
        return $this->iAmOnRoute('sylius_sandbox_core_backend');
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
