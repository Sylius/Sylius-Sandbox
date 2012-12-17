<?php

namespace Sylius\Behat;

use Behat\MinkExtension\Context\MinkContext;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Component\HttpKernel\KernelInterface;
use Behat\Mink\Exception\ElementNotFoundException;

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
     * @Given /^I follow browse "Bookmania" products$/
     */
    public function iFollowBrowseTaxonProducts()
    {
        $this->iClickLinkXpath('//*[@id="content-inner"]/table/tbody/tr[2]/td[3]/div[2]/a[1]');
    }

    /**
     * @Given /^I follow create taxon$/
     */
    public function iFollowCreateTaxon()
    {
        $this->iClickLinkXpath('//*[@id="content-inner"]/div[2]/a[2]');
    }

    /**
     * @Given /^I follow edit taxon "Bookmania"$/
     */
    public function iFollowEditTaxon()
    {
        $this->iClickLinkXpath('//*[@id="content-inner"]/table/tbody/tr[2]/td[3]/div[2]/a[2]');
    }
    /**
     * @Given /^I follow delete taxon "Bookmania"$/
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

    /**
     * Follows taxonomy action from taxonomies list table.
     *
     * @param string $taxonomy taxonomy name
     * @param string $selector css selector to find link to follow
     */
    public function iFollowTaxonomyLink($taxonomy, $selector)
    {
        $taxonomies = $this->getActualValuesInTable('taxonomies-list', 1);
        foreach($taxonomies as $row => $taxonomycell) {
            if ($taxonomycell->getText() === $taxonomy) {
                $actionsColumn = $this->getActualValuesInTable('taxonomies-list', 3);
                return $this->visit(
                    $actionsColumn[$row]
                        ->find('css', $selector)
                        ->getAttribute('href')
                );
            }
        }
 
        throw new ElementNotFoundException(
            $this->getSession(), 'link', 'css', $selector
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
