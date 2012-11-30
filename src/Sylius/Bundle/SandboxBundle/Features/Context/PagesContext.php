<?php

namespace Sylius\Bundle\SandboxBundle\Features\Context;

use Behat\Behat\Context\BehatContext;
use Behat\Behat\Context\Step;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Moving around page context.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class PagesContext extends BehatContext implements KernelAwareInterface
{
    /**
     * Kernel.
     *
     * @var KernelInterface
     */
    private $kernel;

    /**
     * {@inheritdoc}
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @Given /^I am on store homepage$/
     */
    public function iAmOnStoreHomepage()
    {
        return $this->iAmOn($this->generateUrl('sylius_sandbox_core_frontend'));
    }

    /**
     * @Then /^I should be on store homepage$/
     */
    public function iShouldBeOnStoreHomepage()
    {
        return $this->iShouldBeOn($this->generateUrl('sylius_sandbox_core_frontend'));
    }

    /**
     * @Then /^I should be on login page$/
     */
    public function iShouldBeOnLoginPage()
    {
        return $this->iShouldBeOn($this->generateUrl('fos_user_security_login'));
    }

    /**
     * @Then /^I should be on registration page$/
     */
    public function iShouldBeOnRegistrationPage()
    {
        return $this->iShouldBeOn($this->generateUrl('fos_user_registration_register'));
    }

    private function iAmOn($path)
    {
        return new Step\Given(sprintf('I am on "%s"', $path));
    }

    private function iShouldBeOn($path)
    {
        return new Step\Given(sprintf('I should be on "%s"', $path));
    }

    private function generateUrl($route, array $params = array())
    {
        return $this->getRouter()->generate($route, $params);
    }

    private function getRouter()
    {
        return $this->kernel->getContainer()->get('router');
    }
}
