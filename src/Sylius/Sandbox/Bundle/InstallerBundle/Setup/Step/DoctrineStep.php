<?php

namespace Sylius\Sandbox\Bundle\InstallerBundle\Setup\Step;

use Sylius\Bundle\InstallerBundle\Setup\Step\ContainerAwareStep;

class DoctrineStep extends ContainerAwareStep
{
    public function execute()
    {
        return $this->container->get('templating')->renderResponse('SandboxInstallerBundle:Setup/Step:doctrine.html.twig', array(
            'step' => $this
        ));
    }
}
