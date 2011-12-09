<?php

namespace Sylius\Sandbox\Bundle\InstallerBundle\Setup\Step;

use Sylius\Bundle\InstallerBundle\Setup\Step\ContainerAwareStep;

class DoctrineStep extends ContainerAwareStep
{
    public function execute()
    {
        $connection = $this->container->get('doctrine')->getConnection();
        $sql = file_get_contents(__DIR__ .'/../../Resources/schema/doctrine.orm.sql');
        
        $result = $connection->query($sql);
        
        return $this->container->get('templating')->renderResponse('SandboxInstallerBundle:Setup/Install/Step:doctrine.html.twig', array(
            'result' => $result,
            'step' => $this
        ));
    }
}
