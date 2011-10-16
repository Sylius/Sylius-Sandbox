<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

/**
 * Sylius sanbox application kernel.
 * Powered by Symfony2.
 * 
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class AppKernel extends Kernel
{   
    /**
     * Register bundles in kernel.
     */
    public function registerBundles()
    {
        $bundles = array(
            
            /*
             * Third party bundles.
             */
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\DoctrineBundle\DoctrineBundle(),
            new WhiteOctober\PagerfantaBundle\WhiteOctoberPagerfantaBundle(),
                   
            /*
             * Sylius bundles.
             */
            new Sylius\Bundle\CatalogBundle\SyliusCatalogBundle(),
            new Sylius\Bundle\AssortmentBundle\SyliusAssortmentBundle(),
            
            /*
             * Application specific bundles.
             */
            new Application\Bundle\CoreBundle\ApplicationCoreBundle(),
            new Application\Bundle\AssortmentBundle\ApplicationAssortmentBundle(),
            new Application\Bundle\CatalogBundle\ApplicationCatalogBundle(),
        );

        if ($this->isDebug()) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
        }
        
        return $bundles;
    }

    /**
     * Register root dir.
     */
    public function registerRootDir()
    {
        return __DIR__;
    }

    /**
     * Register dependency injection container configuration.
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/container/'.$this->getEnvironment().'.yml');
    }
}
