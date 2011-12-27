<?php

namespace Sylius\Sandbox\Bundle\InstallerBundle\Setup\Step;

use Sylius\Bundle\InstallerBundle\Setup\Step\ContainerAwareStep;

class DoctrineStep extends ContainerAwareStep
{
    public function execute()
    {
        $entityManager = $this->container->get('doctrine')->getEntityManager();
        $metadatas = $entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($entityManager);
        
        $result = true;
        $schemaTool->createSchema($metadatas);
            
        return $this->container->get('templating')->renderResponse('SandboxInstallerBundle:Setup/Install/Step:doctrine.html.twig', array(
            'result' => $result,
            'step' => $this
        ));
    }
}
