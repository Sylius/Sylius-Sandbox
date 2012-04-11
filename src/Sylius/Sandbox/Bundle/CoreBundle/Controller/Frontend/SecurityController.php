<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Sandbox\Bundle\CoreBundle\Controller\Frontend;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Security controller.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class SecurityController extends ContainerAware
{
    public function loginAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();

        if (is_object($user) && $user instanceof UserInterface) {
            return new RedirectResponse($this->container->get('router')->generate('sylius_sandbox_core_frontend'));
        }

        $request = $this->container->get('request');
        $session = $request->getSession();

        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } elseif (null !== $session && $session->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }

        if ($error) {
            $error = $error->getMessage();
        }

        $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::LAST_USERNAME);

        return $this->container->get('templating')->renderResponse('SandboxCoreBundle:Frontend/Security:login.html.twig', array(
            'lastUsername' => $lastUsername,
            'errorMessage' => $error,
        ));
    }

    public function logoutAction()
    {
        throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
    }

    public function checkAction()
    {
        throw new \RuntimeException('You must configure the check path in your security configuration.');
    }
}
