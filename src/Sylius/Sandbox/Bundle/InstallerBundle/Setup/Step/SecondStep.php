<?php

namespace Sylius\Sandbox\Bundle\InstallerBundle\Setup\Step;

use Sylius\Bundle\InstallerBundle\Setup\Step\ContainerAwareStep;

class SecondStep extends ContainerAwareStep
{
    public function execute()
    {
        return $this->container->get('templating')->renderResponse('SandboxInstallerBundle:Setup/Step:second.html.twig', array(
            'step' => $this
        ));
    }
}
