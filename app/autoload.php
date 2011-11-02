<?php

require __DIR__.'/../vendor/libraries/symfony/src/Symfony/Component/ClassLoader/UniversalClassLoader.php';

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Symfony\Component\ClassLoader\UniversalClassLoader;

// Autoloader of application.

$loader = new UniversalClassLoader();

$loader->registerNamespaces(array(
    'Symfony'         					  => __DIR__.'/../vendor/libraries/symfony/src',
    'Pagerfanta'						  => __DIR__.'/../vendor/libraries/pagerfanta/src',
    'Doctrine\\Common'                    => __DIR__.'/../vendor/libraries/doctrine-common/lib',
    'Doctrine\\DBAL'					  => __DIR__.'/../vendor/libraries/doctrine-dbal/lib',
    'Doctrine'							  => __DIR__.'/../vendor/libraries/doctrine/lib',
	'Monolog'       				      => __DIR__.'/../vendor/libraries/monolog/src',
    'Metadata'       					  => __DIR__.'/../vendor/libraries/metadata/src',

    'Application'						  => __DIR__.'/../src',

    'Liip'								  => __DIR__.'/../vendor/bundles',
    'WhiteOctober\PagerfantaBundle'       => __DIR__.'/../vendor/bundles',
	'Sylius'						      => __DIR__.'/../vendor/bundles',
    
));

$loader->registerPrefixes(array(
    'Twig_Extensions_'                    => __DIR__.'/../vendor/libraries/twig-extensions/lib',
    'Twig_'                               => __DIR__.'/../vendor/libraries/twig/lib',
));

// Swiftmailer.
require_once __DIR__.'/../vendor/libraries/swiftmailer/lib/classes/Swift.php'; 
Swift::registerAutoload(__DIR__.'/../vendor/libraries/swiftmailer/lib/swift_init.php');

// Intl stubs.
if (!function_exists('intl_get_error_code')) {
    require_once __DIR__.'/../vendor/libraries/symfony/src/Symfony/Component/Locale/Resources/stubs/functions.php';

    $loader->registerPrefixFallbacks(array(__DIR__.'/../vendor/libraries/symfony/src/Symfony/Component/Locale/Resources/stubs'));
}

$loader->register();

