<?php

namespace Sylius\Sandbox\Bundle\GuardBundle\Controller\Frontend;

use Sylius\Bundle\GuardBundle\Controller\Frontend\UserController as BaseUserController;
use Symfony\Component\HttpFoundation\RedirectResponse;

class UserController extends BaseUserController
{
    public function registerAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();

        if (is_object($user) || $user instanceof UserInterface) {
            return new RedirectResponse($this->container->get('router')->generate('app_core_frontend'));
        }

        return parent::registerAction();
    }
}
