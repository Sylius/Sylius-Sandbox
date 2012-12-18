<?php

namespace Sylius\Behat;

use Behat\Gherkin\Node\TableNode;

/**
 * Data context.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class DataContext extends BaseContext
{
    /**
     * @Given /^there are following users:$/
     * @Given /^the following users exist:$/
     */
    public function thereAreFollowingUsers(TableNode $table)
    {
        $entityManager = $this->getEntityManager();
        $userManager = $this->getService('fos_user.user_manager');

        foreach ($table->getHash() as $data) {
            $data = array_merge(
                array(
                    'enabled' => true,
                ),
                $data
            );

            $user = $userManager->createUser();
            $user->setUsername($data['username']);
            $user->setEmail(sprintf('%s@sylius.org', strtolower($data['username'])));
            $user->setPlainPassword($data['password']);
            if (isset($data['role'])) {
                $user->setRoles(array($data['role']));
            }
            $user->setEnabled($data['enabled']);

            $userManager->updateUser($user, false);
        }

        $entityManager->flush();
    }

    /**
     * @Given /^there are following taxonomies:$/
     */
    public function thereAreFollowingTaxonomies(TableNode $table)
    {
        $taxonomyRepository = $this->getService('sylius_taxonomies.repository.taxonomy');
        $taxonomyManager = $this->getService('sylius_taxonomies.manager.taxonomy');
        $taxonRepository = $this->getService('sylius_taxonomies.repository.taxon');

        foreach ($table->getHash() as $data) {
            $taxonomy = $taxonomyRepository->createNew();
            $taxonomy->setName($data['taxonomy']);
            foreach (explode(',', $data['taxons']) as $taxonName) {
                $taxon = $taxonRepository->createNew();
                $taxon->setName(trim($taxonName));
                $taxonomy->addTaxon($taxon);
            }
            $taxonomyManager->persist($taxonomy);
        }

        $taxonomyManager->flush();
    }
}
