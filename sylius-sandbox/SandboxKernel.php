<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius;

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

/**
 * Sylius sanbox application kernel.
 * Powered by Symfony2.
 * 
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class SandboxKernel extends Kernel
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
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new \Symfony\Bundle\TwigBundle\TwigBundle(),
            new \Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new \Symfony\Bundle\MonologBundle\MonologBundle(),
            new \Symfony\Bundle\DoctrineBundle\DoctrineBundle(),
            new \Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new \WhiteOctober\PagerfantaBundle\WhiteOctoberPagerfantaBundle(),
            new \Liip\ThemeBundle\LiipThemeBundle(),
                   
            /*
             * Sylius bundles.
             */
            new \Sylius\Bundle\CatalogBundle\SyliusCatalogBundle(),
            new \Sylius\Bundle\AssortmentBundle\SyliusAssortmentBundle(),
            new \Sylius\Bundle\NewsletterBundle\SyliusNewsletterBundle(),
            new \Sylius\Bundle\CartBundle\SyliusCartBundle(),
            new \Sylius\Bundle\ThemingBundle\SyliusThemingBundle(),
            new \Sylius\Bundle\BloggerBundle\SyliusBloggerBundle(),
            new \Sylius\Bundle\SalesBundle\SyliusSalesBundle(),
            
            /*
             * Sandbox specific bundles.
             */
            new \Sylius\Sandbox\Bundle\CoreBundle\SandboxCoreBundle(),
            new \Sylius\Sandbox\Bundle\CatalogBundle\SandboxCatalogBundle(),
            new \Sylius\Sandbox\Bundle\AssortmentBundle\SandboxAssortmentBundle(),
            new \Sylius\Sandbox\Bundle\NewsletterBundle\SandboxNewsletterBundle(),
            new \Sylius\Sandbox\Bundle\CartBundle\SandboxCartBundle(),
            new \Sylius\Sandbox\Bundle\ThemingBundle\SandboxThemingBundle(),
            new \Sylius\Sandbox\Bundle\BloggerBundle\SandboxBloggerBundle(),
            new \Sylius\Sandbox\Bundle\SalesBundle\SandboxSalesBundle(),
            new \Sylius\Sandbox\Bundle\PluginsBundle\SandboxPluginsBundle()
        );

        $bundles[] = new \Sylius\Bundle\PluginsBundle\SyliusPluginsBundle($this, $bundles);
        
        if ($this->isDebug()) {
            $bundles[] = new \Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
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
