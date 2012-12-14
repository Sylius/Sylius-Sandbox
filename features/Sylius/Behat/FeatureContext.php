<?php

namespace Sylius\Behat;

use Behat\MinkExtension\Context\MinkContext;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Component\HttpKernel\KernelInterface;

require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';

/**
 * Main feature context.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class FeatureContext extends MinkContext implements KernelAwareInterface
{
    /**
     * Kernel.
     *
     * @var KernelInterface
     */
    private $kernel;

    /**
     * Parameters.
     *
     * @var array
     */
    private $parameters;

    /**
     * Initializes context with parameters from behat.yml.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;

        // Pages context.
        $this->useContext('pages', new PagesContext());

        // Data contexts.
        $this->useContext('data', new DataContext());
    }

    /**
     * {@inheritdoc}
     */
     public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @BeforeScenario
     */
    public function purgeDatabase()
    {
        $em = $this->kernel->getContainer()->get('doctrine.orm.entity_manager');

        $purger = new ORMPurger($em);
        $purger->purge();
    }

    /**
     * @Given /^I follow edit taxonomy$/
     */
    public function iFollowEditTaxonomy()
    {
        $this->iClickLinkXpath('//*[@id="content-inner"]/table/tbody/tr[2]/td[4]/div/a[1]');
    }

    /**
     * @Given /^I follow delete taxonomy$/
     */
    public function iFollowDeleteTaxonomy()
    {
        $this->iClickLinkXpath('//*[@id="content-inner"]/table/tbody/tr[2]/td[4]/div/a[2]');
    }

    /**
     * @Given /^I follow create taxon$/
     */
    public function iFollowCreateTaxon()
    {
        $this->iClickLinkXpath('//*[@id="content-inner"]/div[2]/a[2]');
    }

    /**
     * @Given /^I follow edit taxon$/
     */
    public function iFollowEditTaxon()
    {
        $this->iClickLinkXpath('//*[@id="content-inner"]/table/tbody/tr[2]/td[3]/div[2]/a[2]');
    }
    /**
     * @Given /^I follow delete taxon$/
     */
    public function iFollowDeleteTaxon()
    {
        $this->iClickLinkXpath('//*[@id="content-inner"]/table/tbody/tr[2]/td[3]/div[2]/a[3]');
    }

    /**
     * @Then /^I should see (\d+) products on the page$/
     */
    public function iShouldSeeThatMuchProductsOnThePage($expected)
    {
        $actual = count($this->getSession()->getPage()->findAll('css', '.product-grid .well-small'));

        assertEquals(
            $expected,
            $actual,
            sprintf(
                'Failed asserting there are "%s" products on the page, in reality they are "%s"',
                $expected,
                $actual
            )
        );
    }

    private function iClickLinkXpath($xpath)
    {
        $this
            ->getSession()
            ->getPage()
            ->find('xpath', $xpath)
            ->click()
        ;
    }
}
