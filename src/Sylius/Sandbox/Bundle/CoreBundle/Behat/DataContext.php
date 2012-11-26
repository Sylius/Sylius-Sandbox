<?php

namespace Sylius\Sandbox\Bundle\CoreBundle\Behat;

use Behat\Behat\Context\BehatContext;
use Behat\Behat\Context\Step;
use Behat\Gherkin\Node\TableNode;
use Sylius\Sandbox\Bundle\CoreBundle\Entity\User;
use Sylius\Sandbox\Bundle\CoreBundle\Features\Context\AbstractDataContext;

/**
 * User data context.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class DataContext extends AbstractDataContext
{
    /**
     * @Given /^there are following users:$/
     * @Given /^the following users exist:$/
     */
    public function thereAreFollowingUsers(TableNode $table)
    {
        $entityManager = $this->getEntityManager();
        $userManager = $this->kernel->getContainer()->get('fos_user.user_manager');

        foreach ($table->getHash() as $data) {
            $data = array_merge(
                array(
                    'enabled'     => true,
                ),
                $data
            );


            $user = $userManager->createUser();
            $user->setUsername($data['username']);
            $user->setEmail(sprintf('%s@sylius.org', strtolower($data['username'])));
            $user->setPlainPassword($data['password']);
            $user->setEnabled($data['enabled']);

            $userManager->updateUser($user, false);
        }

        $entityManager->flush();
    }
}
