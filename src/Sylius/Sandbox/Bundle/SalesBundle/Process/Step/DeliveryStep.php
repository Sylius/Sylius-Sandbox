<?php

namespace Sylius\Sandbox\Bundle\SalesBundle\Process\Step;

use Sylius\Bundle\FlowBundle\Process\Context\ProcessContextInterface;
use Sylius\Bundle\FlowBundle\Process\Step\ContainerAwareStep;

/**
 * Delivery step.
 * Allows user to select delivery method for order.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class DeliveryStep extends ContainerAwareStep
{
    /**
     * {@inheritdoc}
     */
    public function display(ProcessContextInterface $context)
    {
        return $this->container->get('templating')->renderResponse('SyliusSalesBundle:Process/Checkout/Step:delivery.html.twig', array(
            'context' => $context
        ));
    }
}
