<?php

namespace Sylius\Sandbox\Bundle\SalesBundle\Process\Step;

use FOS\UserBundle\Model\UserInterface;
use Sylius\Bundle\AddressingBundle\Model\AddressInterface;
use Sylius\Bundle\FlowBundle\Process\Context\ProcessContextInterface;
use Sylius\Bundle\FlowBundle\Process\Step\ContainerAwareStep;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * Security step.
 * If user is not logged in, displays login & registration form.
 * Also guest checkout is possible.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class SecurityStep extends ContainerAwareStep
{
    /**
     * {@inheritdoc}
     */
    public function displayAction(ProcessContextInterface $context)
    {
        $this->overrideSecurityTargetPath();

        $registrationForm = $this->container->get('fos_user.registration.form');

        return $this->container->get('templating')->renderResponse('SyliusSalesBundle:Process/Checkout/Step:security.html.twig', array(
            'context'          => $context,
            'registrationForm' => $registrationForm->createView(),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function forwardAction(ProcessContextInterface $context)
    {
        $this->overrideSecurityTargetPath();

        $registrationForm = $this->container->get('fos_user.registration.form');
        $registrationFormHandler = $this->container->get('fos_user.registration.form.handler');

        $process = $registrationFormHandler->process(false);

        if ($process) {
            $this->authenticateUser($registrationForm->getData());

            // Registration was successful, complete this step.
            $context->complete();

            return;
        }

        return $this->container->get('templating')->renderResponse('SyliusSalesBundle:Process/Checkout/Step:security.html.twig', array(
            'context'          => $context,
            'registrationForm' => $registrationForm->createView(),
        ));
    }

    /**
     * Override security target path, it will redirect user to checkout after login.
     */
    private function overrideSecurityTargetPath()
    {
        $url = $this->container->get('router')->generate('sylius_sandbox_checkout_start', array(), true);

        $this->container->get('session')->set('_security.target_path', $url);
    }

    /**
     * Authenticate user.
     *
     * @param UserInterface $user
     */
    private function authenticateUser(UserInterface $user)
    {
        $providerKey = $this->container->getParameter('fos_user.firewall_name');
        $token = new UsernamePasswordToken($user, null, $providerKey, $user->getRoles());

        $this->container->get('security.context')->setToken($token);
    }
}

