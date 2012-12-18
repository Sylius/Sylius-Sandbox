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

/**
 * User context.
 *
 * @author Саша Стаменковић <umpirsky@gmail.com>
 */
class UserContext extends BaseContext
{
    /**
     * @Given /^I am on store homepage$/
     */
    public function iAmOnStoreHomepage()
    {
        return $this->iAmOnRoute('sylius_sandbox_core_frontend');
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
}
