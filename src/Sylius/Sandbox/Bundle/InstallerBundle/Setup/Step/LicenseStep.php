<?php

namespace Sylius\Sandbox\Bundle\InstallerBundle\Setup\Step;

use Sylius\Bundle\InstallerBundle\Setup\Step\ContainerAwareStep;

class LicenseStep extends ContainerAwareStep
{
    public function execute()
    {
        $this->complete();
        
        return $this->container->get('templating')->renderResponse('SandboxInstallerBundle:Setup/Step:license.html.twig', array(
            'step' => $this
        ));
    }
}
