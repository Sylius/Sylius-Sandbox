<?php

namespace Sylius\Bundle\SandboxBundle\Process\Scenario;

use Sylius\Bundle\FlowBundle\Process\Builder\ProcessBuilderInterface;
use Sylius\Bundle\FlowBundle\Process\Scenario\ProcessScenarioInterface;
use Sylius\Bundle\SandboxBundle\Process\Step;
use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Example sandbox checkout process.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class CheckoutProcessScenario extends ContainerAware implements ProcessScenarioInterface
{
    /**
     * {@inheritdoc}
     */
    public function build(ProcessBuilderInterface $builder)
    {
        $cart = $this->container->get('sylius_cart.provider')->getCart();

        $builder
            ->add('security', new Step\SecurityCheckoutStep())
            ->add('addressing', new Step\AddressingCheckoutStep())
            ->add('shipping', new Step\ShippingCheckoutStep())
            ->add('finalize', new Step\FinalizeCheckoutStep())
            ->setDisplayRoute('sylius_sandbox_checkout_display')
            ->setForwardRoute('sylius_sandbox_checkout_forward')
            ->setRedirect('sylius_sandbox_core_frontend')

            ->validate(function () use ($cart) {
                return !$cart->isEmpty();
            })
        ;
    }
}
