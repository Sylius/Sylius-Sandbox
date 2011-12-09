<?php

namespace Sylius\Sandbox\Bundle\InstallerBundle\Setup\Step;

use Sylius\Bundle\InstallerBundle\Setup\Step\ContainerAwareStep;

class PreconditionsStep extends ContainerAwareStep
{
    public function execute()
    {
        $issues = array();
        
        if (!function_exists('token_get_all')) {
            $issues[] = 'Install and enable the <strong>Tokenizer</strong> extension.';
        }
        
        if (!function_exists('mb_strlen')) {
            $issues[] = 'Install and enable the <strong>mbstring</strong> extension.';
        }
        
        if (!function_exists('iconv')) {
            $issues[] = 'Install and enable the <strong>iconv</strong> extension.';
        }
        
        if (!function_exists('utf8_decode')) {
            $issues[] = 'Install and enable the <strong>XML</strong> extension.';
        }
        
        if (!defined('PHP_WINDOWS_VERSION_BUILD') && !function_exists('posix_isatty')) {
            $issues[] = 'Install and enable the <strong>php_posix</strong> extension (used to colorize the CLI output).';
        }
        
        if (!class_exists('DomDocument')) {
            $issues[] = 'Install and enable the <strong>php-xml</strong> module.';
        }
        
        if (!((function_exists('apc_store') && ini_get('apc.enabled')) || function_exists('eaccelerator_put') && ini_get('eaccelerator.enable') || function_exists('xcache_set'))) {
            $issues[] = 'Install and enable a <strong>PHP accelerator</strong> like APC (highly recommended).';
        }
        
        if (!class_exists('Locale')) {
            $issues[] = 'Install and enable the <strong>intl</strong> extension.';
        } else {
            $version = '';
        
            if (defined('INTL_ICU_VERSION')) {
                $version =  INTL_ICU_VERSION;
            } else {
                $reflector = new \ReflectionExtension('intl');
        
                ob_start();
                $reflector->info();
                $output = strip_tags(ob_get_clean());
        
                preg_match('/^ICU version (.*)$/m', $output, $matches);
                $version = $matches[1];
            }
        
            if (!version_compare($version, '4.0', '>=')) {
                $issues[] = 'Upgrade your <strong>intl</strong> extension with a newer ICU version.';
            }
        }
        
        if (ini_get('short_open_tag')) {
            $phpini = true;
            $issues[] = 'Set <strong>short_open_tag</strong> to <strong>off</strong> in php.ini.';
        }
        
        if (ini_get('magic_quotes_gpc')) {
            $phpini = true;
            $issues[] = 'Set <strong>magic_quotes_gpc</strong> to <strong>off</strong> in php.ini.';
        }
        
        if (ini_get('register_globals')) {
            $phpini = true;
            $issues[] = 'Set <strong>register_globals</strong> to <strong>off</strong> in php.ini.';
        }
        
        if (ini_get('session.auto_start')) {
            $phpini = true;
            $issues[] = 'Set <strong>session.auto_start</strong> to <strong>off</strong> in php.ini.';
        }
        
        if (!is_writable($this->container->get('kernel')->getRootDir() . '/config/container/parameters.yml')) {
            $issues[] = 'Change the permissions of the "<strong>sylius-sandbox/config/container/parameters.yml</strong>"
                file so that the web server can write into it.';
        }
        
        $this->complete();
        
        return $this->container->get('templating')->renderResponse('SandboxInstallerBundle:Setup/Install/Step:preconditions.html.twig', array(
            'issues' => $issues,
            'step' => $this
        ));
    }
}
