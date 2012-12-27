<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Symfony\Component\ClassLoader\DebugUniversalClassLoader;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Debug\ErrorHandler;
use Symfony\Component\HttpKernel\Debug\ExceptionHandler;
use Symfony\Component\HttpKernel\Kernel;

// Require autoload.
require_once __DIR__.'/autoload.php';

/**
 * Sylius sanbox application kernel.
 * Powered by Symfony2.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class SyliusSandboxKernel extends Kernel
{
    /**
     * {@inheritdoc}
     */
    public function registerBundles()
    {
        $bundles = array(

            /*
             * Sylius bundles.
             */
            new Sylius\Bundle\CartBundle\SyliusCartBundle(),
            new Sylius\Bundle\AddressingBundle\SyliusAddressingBundle(),
            new Sylius\Bundle\AssortmentBundle\SyliusAssortmentBundle(),
            new Sylius\Bundle\CategorizerBundle\SyliusCategorizerBundle(),
            new Sylius\Bundle\FlowBundle\SyliusFlowBundle(),
            new Sylius\Bundle\InventoryBundle\SyliusInventoryBundle(),
            new Sylius\Bundle\ResourceBundle\SyliusResourceBundle(),
            new Sylius\Bundle\SalesBundle\SyliusSalesBundle(),
            new Sylius\Bundle\BloggerBundle\SyliusBloggerBundle(),
            new Sylius\Bundle\TaxonomiesBundle\SyliusTaxonomiesBundle(),
            new Sylius\Bundle\TaxationBundle\SyliusTaxationBundle(),
            new Sylius\Bundle\ShippingBundle\SyliusShippingBundle(),
            new Sylius\Bundle\SettingsBundle\SyliusSettingsBundle(),

            new Avalanche\Bundle\ImagineBundle\AvalancheImagineBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle(),
            new FOS\CommentBundle\FOSCommentBundle(),
            new FOS\RestBundle\FOSRestBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle($this),
            new Knp\Bundle\MarkdownBundle\KnpMarkdownBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Mopa\Bundle\BootstrapBundle\MopaBootstrapBundle(),
            new Liip\DoctrineCacheBundle\LiipDoctrineCacheBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new WhiteOctober\PagerfantaBundle\WhiteOctoberPagerfantaBundle(),

            /*
             * Sandbox specific bundles.
             */
            new Sylius\Bundle\SandboxBundle\SyliusSandboxBundle(),
        );

        if ($this->isDebug()) {
            $bundles[] = new \Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
        }

        return $bundles;
    }

    /**
     * {@inheritdoc}
     */
    public function registerRootDir()
    {
        return __DIR__;
    }

    /**
     * {@inheritdoc}
     */
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

        ini_set('date.timezone', 'UTC');
    }

    /**
     * {@inheritdoc}
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
