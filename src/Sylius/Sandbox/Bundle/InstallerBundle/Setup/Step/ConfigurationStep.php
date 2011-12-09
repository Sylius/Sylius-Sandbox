<?php

namespace Sylius\Sandbox\Bundle\InstallerBundle\Setup\Step;

use Symfony\Component\HttpFoundation\RedirectResponse;

use Sylius\Sandbox\Bundle\InstallerBundle\Setup\Form\Type\ParametersFormType;
use Sylius\Sandbox\Bundle\InstallerBundle\Setup\Model\Parameters;
use Sylius\Bundle\InstallerBundle\Setup\Step\ContainerAwareStep;

class ConfigurationStep extends ContainerAwareStep
{
    public function execute()
    {
        $request = $this->container->get('request');
        
        $parameters = new Parameters();
        
        $form = $this->container->get('form.factory')->create(new ParametersFormType());
        $form->setData($parameters);
        
        if ('POST' == $request->getMethod()) {
            $form->bindRequest($request);
        
            if ($form->isValid()) {
                $configuration = $this->container->get('templating')->render('SandboxInstallerBundle:Setup:parameters.yml.twig', array(
                    'parameters' => $parameters
                ));
                
                $kernel = $this->container->get('kernel');
                
                $saved = false;
                
                if (is_writeable($parametersFile = $kernel->getRootDir() . '/config/container/parameters.yml')) {
                    file_put_contents($parametersFile, $configuration);
                    $saved = true;
                    $this->complete();
                }
                
                return $this->container->get('templating')->renderResponse('SandboxInstallerBundle:Setup/Install/Step:configured.html.twig', array(
                    'saved' => $saved,
                    'configuration' => $configuration,
                    'parameters' => $parameters,
                    'step' => $this
                ));
            }
        }
        
        return $this->container->get('templating')->renderResponse('SandboxInstallerBundle:Setup/Install/Step:configuration.html.twig', array(
            'form' => $form->createView(),
            'step' => $this
        ));
    }
}
