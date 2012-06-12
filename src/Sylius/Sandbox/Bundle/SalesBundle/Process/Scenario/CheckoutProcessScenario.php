<?php

namespace Sylius\Sandbox\Bundle\SalesBundle\Process\Scenario;

use Sylius\Bundle\FlowBundle\Process\Builder\ProcessBuilderInterface;
use Sylius\Bundle\FlowBundle\Process\Scenario\ProcessScenarioInterface;
use Sylius\Sandbox\Bundle\SalesBundle\Process\Step;

/**
 * Example sandbox checkout process.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class CheckoutProcessScenario implements ProcessScenarioInterface
{
    /**
     * {@inheritdoc}
     */
    public function build(ProcessBuilderInterface $builder)
    {
        $builder
            ->add('delivery', new Step\DeliveryStep())
            //->add('billing', new Step\BillingStep())
            //->add('finalize', new Step\FinalizeStep())
        ;
    }
}
