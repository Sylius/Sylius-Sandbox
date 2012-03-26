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

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\ClassLoader\DebugUniversalClassLoader;
use Symfony\Component\HttpKernel\Debug\ErrorHandler;
use Symfony\Component\HttpKernel\Debug\ExceptionHandler;
use Symfony\Component\HttpKernel\Kernel;

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
            new \Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new \Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new \Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new \Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new \Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle(),
            new \Liip\ThemeBundle\LiipThemeBundle(),
            new \Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new \WhiteOctober\PagerfantaBundle\WhiteOctoberPagerfantaBundle(),
            new \Knp\Bundle\MarkdownBundle\KnpMarkdownBundle(),
            new \Ivory\CKEditorBundle\IvoryCKEditorBundle(),

            /*
             * Sylius bundles.
             */
            new \Sylius\Bundle\CategorizerBundle\SyliusCategorizerBundle(),
            new \Sylius\Bundle\AssortmentBundle\SyliusAssortmentBundle(),
            new \Sylius\Bundle\NewsletterBundle\SyliusNewsletterBundle(),
            new \Sylius\Bundle\CartBundle\SyliusCartBundle(),
            new \Sylius\Bundle\ThemingBundle\SyliusThemingBundle(),
            new \Sylius\Bundle\BloggerBundle\SyliusBloggerBundle(),
            new \Sylius\Bundle\SalesBundle\SyliusSalesBundle(),
            new \Sylius\Bundle\InstallerBundle\SyliusInstallerBundle(),
            new \Sylius\Bundle\AddressingBundle\SyliusAddressingBundle(),
            new \Sylius\Bundle\GuardBundle\SyliusGuardBundle(),

            /*
             * Sandbox specific bundles.
             */
            new \Sylius\Sandbox\Bundle\CoreBundle\SandboxCoreBundle(),
            new \Sylius\Sandbox\Bundle\AssortmentBundle\SandboxAssortmentBundle(),
            new \Sylius\Sandbox\Bundle\NewsletterBundle\SandboxNewsletterBundle(),
            new \Sylius\Sandbox\Bundle\CartBundle\SandboxCartBundle(),
            new \Sylius\Sandbox\Bundle\ThemingBundle\SandboxThemingBundle(),
            new \Sylius\Sandbox\Bundle\BloggerBundle\SandboxBloggerBundle(),
            new \Sylius\Sandbox\Bundle\SalesBundle\SandboxSalesBundle(),
            new \Sylius\Sandbox\Bundle\PluginsBundle\SandboxPluginsBundle(),
            new \Sylius\Sandbox\Bundle\InstallerBundle\SandboxInstallerBundle(),
            new \Sylius\Sandbox\Bundle\AddressingBundle\SandboxAddressingBundle(),
            new \Sylius\Sandbox\Bundle\GuardBundle\SandboxGuardBundle()
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

    public function init()
    {
        if ($this->debug) {
            ini_set('display_errors', 1);
            error_reporting(-1);

            DebugUniversalClassLoader::enable();
            ErrorHandler::register();
            if ('cli' !== php_sapi_name()) {
                ExceptionHandler::register();
            }
        } else {
            ini_set('display_errors', 0);
        }
    }

    /**
     * Register dependency injection container configuration.
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $base = __DIR__.'/config/container/'.$this->getEnvironment();
        if (file_exists($base.'.local.yml')) {
            $base .= '.local';
        }
        $loader->load($base.'.yml');
    }
}
