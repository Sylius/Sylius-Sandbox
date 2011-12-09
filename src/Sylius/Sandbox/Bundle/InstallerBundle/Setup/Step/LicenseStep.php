<?php

namespace Sylius\Sandbox\Bundle\InstallerBundle\Setup\Step;

use Sylius\Bundle\InstallerBundle\Setup\Step\ContainerAwareStep;

class LicenseStep extends ContainerAwareStep
{
    public function execute()
    {
        $installed = $this->container->getParameter('sylius.installed');
        
        if (!$installed) {
            $this->complete();
            return $this->container->get('templating')->renderResponse('SandboxInstallerBundle:Setup/Install/Step:license.html.twig', array(
            	'step'      => $this
            ));
        }
        
        return $this->container->get('templating')->renderResponse('SandboxInstallerBundle:Setup/Install/Step:installed.html.twig', array(
            'step'      => $this
        ));
    }
}
