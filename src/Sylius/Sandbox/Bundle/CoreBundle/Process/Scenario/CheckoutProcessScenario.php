<?php

namespace Sylius\Sandbox\Bundle\SalesBundle\Process\Scenario;

use Sylius\Bundle\FlowBundle\Process\Builder\ProcessBuilderInterface;
use Sylius\Bundle\FlowBundle\Process\Scenario\ProcessScenarioInterface;
use Sylius\Sandbox\Bundle\SalesBundle\Process\Step;
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

        if (!is_object($this->container->get('security.context')->getToken()->getUser())) {
            $builder->add('security', new Step\SecurityStep());
        }

        $builder
            ->add('delivery', new Step\DeliveryStep())
            ->add('billing', new Step\BillingStep())
            ->add('finalize', new Step\FinalizeStep())
            ->setDisplayRoute('sylius_sandbox_checkout_display')
            ->setForwardRoute('sylius_sandbox_checkout_forward')
            ->setRedirect('sylius_sandbox_core_frontend')

            ->validate(function () use ($cart) {
                return !$cart->isEmpty();
            })
        ;
    }
}
