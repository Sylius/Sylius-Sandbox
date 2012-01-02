<?php

namespace Sylius\Sandbox\Bundle\GuardBundle\Controller\Frontend;

use Sylius\Bundle\GuardBundle\Controller\Frontend\SecurityController as BaseSecurityController;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SecurityController extends BaseSecurityController
{
    public function loginAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        
        if (is_object($user) || $user instanceof UserInterface) {
            return new RedirectResponse($this->container->get('router')->generate('app_core_frontend'));
        }
        
        return parent::loginAction();
    }
}
