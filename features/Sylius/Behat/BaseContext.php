<?php

namespace Sylius\Behat;

use Behat\Behat\Context\BehatContext;
use Behat\Behat\Context\Step;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Base context class.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
abstract class BaseContext extends BehatContext implements KernelAwareInterface
{
    /**
     * Kernel.
     *
     * @var KernelInterface
     */
    protected $kernel;

    /**
     * {@inheritdoc}
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    protected function getEntityManager()
    {
        return $this->getService('doctrine.orm.entity_manager');
    }

    protected function generateUrl($route, array $params = array())
    {
        return $this->getRouter()->generate($route, $params);
    }

    protected function getRouter()
    {
        return $this->kernel->getContainer()->get('router');
    }

    protected function getService($id)
    {
        return $this->kernel->getContainer()->get($id);
    }

    /**
     * Alias to FeatureContext::getSession().
     *
     * @param string|null $name name of the session OR active session will be used
     *
     * @return Session
     */
    public function getSession($name = null)
    {
        return $this->getMainContext()->getSession($name);
    }

    protected function iAmOnRoute($route, array $parameters = array())
    {
        return $this->iAmOn($this->generateUrl($route, $parameters));
    }

    protected function iAmOn($path)
    {
        return new Step\Given(sprintf('I am on "%s"', $path));
    }

    protected function iShouldBeOnRoute($route, array $parameters = array())
    {
        return $this->iShouldBeOn($this->generateUrl($route, $parameters));
    }

    protected function iShouldBeOn($path)
    {
        return new Step\Given(sprintf('I should be on "%s"', $path));
    }
}
