<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Symfony\Component\HttpFoundation\Request;

// Check requirements.

if (!isset($_SERVER['HTTP_HOST'])) {
    exit('This script cannot be run from the CLI. Run it from a browser.');
}

$issues = array();

if (!version_compare(phpversion(), '5.3.2', '>=')) {
    $version = phpversion();
    $issues[] = <<<EOF
        You are running PHP version "<strong>$version</strong>", but Symfony
        needs at least PHP "<strong>5.3.2</strong>" to run. Before using Symfony, install
        PHP "<strong>5.3.2</strong>" or newer.
EOF;
}

if (!file_exists('../vendor')) {
    $issues[] = <<<EOF
        If you have cloned or downloaded Sylius without vendors, please install them first. <br />
    	You can also download the package with vendors from <a href="http://sylius.org">Sylius.org website</a>.
EOF;
}

if (!is_writable(__DIR__ . '/../sylius-sandbox/cache')) {
    $issues[] = 'Change the permissions of the "<strong>sylius-sandbox/cache/</strong>"
        directory so that the web server can write into it.';
}

if (!is_writable(__DIR__ . '/../sylius-sandbox/logs')) {
    $issues[] = 'Change the permissions of the "<strong>sylius-sandbox/logs/</strong>"
        directory so that the web server can write into it.';
}

if (!(!(function_exists('apc_store') && ini_get('apc.enabled')) || version_compare(phpversion('apc'), '3.0.17', '>='))) {
    $issues[] = 'Upgrade your <strong>APC</strong> extension.';
}

if (!function_exists('json_encode')) {
    $issues[] = 'Install and enable the <strong>json</strong> extension.';
}

if (!function_exists('session_start')) {
    $issues[] = 'Install and enable the <strong>session</strong> extension.';
}

if (!function_exists('ctype_alpha')) {
    $issues[] = 'Install and enable the <strong>ctype</strong> extension.';
}

if (!function_exists('token_get_all')) {
    $issues[] = 'Install and enable the <strong>Tokenizer</strong> extension.';
}

if (count($issues) > 0):

?>
<!DOCTYPE html>

<html>
    <head>
        <title>Sylius installer setup.</title>

        <meta charset="UTF-8">

        <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <link rel="stylesheet" href="http://twitter.github.com/bootstrap/1.4.0/bootstrap.min.css">

        <script type="text/javascript" src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
        <script type="text/javascript" src="http://twitter.github.com/bootstrap/1.4.0/bootstrap-dropdown.js"></script>
        
        <style type="text/css">
            html, body {
                background-color: #eee;
            }
            
            body {
                padding-top: 20px;
            }
            
            .topbar-wrapper {
              position: relative;
              height: 40px;
            }
            
            .topbar-wrapper .topbar {
              position: absolute;
              margin: 0 -20px;
            
            }
            
            .topbar-wrapper .topbar .topbar-inner {
              padding-left: 20px;
              padding-right: 20px;
              -webkit-border-radius: 6px 6px 0 0;
                 -moz-border-radius: 6px 6px 0 0;
                      border-radius: 6px 6px 0 0;
            }
            
            .container > footer p {
                text-align: center;
            }
            
            .container {
              width: 820px;
            }
            
            .content {
                background-color: #fff;
                padding: 20px;
                margin: 0 -20px;
                -webkit-border-radius: 0 0 6px 6px;
                   -moz-border-radius: 0 0 6px 6px;
                 border-radius: 0 0 6px 6px;
                -webkit-box-shadow: 0 1px 3px rgba(0,0,0,.15);
                   -moz-box-shadow: 0 1px 3px rgba(0,0,0,.15);
                        box-shadow: 0 1px 3px rgba(0,0,0,.15);
            }
            
            .page-header {
                -webkit-border-radius: 6px 6px 0 0;
                   -moz-border-radius: 6px 6px 0 0;
                        border-radius: 6px 6px 0 0;
                background-color: #f5f5f5;
                padding: 20px 20px 10px;
                margin: -20px -20px 20px;
            }
            
            .content .span6,
            .content .span8 {
                min-height: 500px;
            }
            
            .content .span6 {
                text-align: center;
                margin-left: 0;
                padding-left: 19px;
                border-left: 1px solid #eee;
            }
            
            .installer-option {
                padding: 30px;
            }
            
            .installer-option-desc {
                padding: 30px;
                border-bottom: 1px solid #eee;
            }
            
            .topbar .btn {
                border: 0;
            }
        </style>
        
    </head>
    <body>
        <div class="container">
            <div class="topbar-wrapper" style="z-index: 5;">
                <div class="topbar" data-dropdown="dropdown">
                    <div class="topbar-inner">
                        <div class="container">
                            <ul class="nav">
                                <a class="brand" href="http://sylius.org">Sylius</a>
                                <li class="dropdown" data-dropdown="dropdown">
                                <a href="#" class="dropdown-toggle">Help</a>
                                <ul class="dropdown-menu">
                                <li><a href="http://sylius.org/docs">Documentation</a></li>
                                <li><a href="http://groups.google.com/group/sylius">Mailing list</a></li>
                                </ul>
                                </li>
                            </ul>
                        </div>
                    </div><!-- /topbar-inner -->
                </div><!-- /topbar -->
            </div>
            <div class="content">
                <div class="alert-message error">
                <p><strong>Error.</strong> It looks like your system does not meet the requirements of <strong>Sylius sandbox application</strong>.</p>
                </div>
                <?php foreach($issues as $issue): ?>
                    <div class="alert-message block-message warning">
                        <p><?php echo $issue; ?></p>
                    </div>
                <?php endforeach; ?>
                </div>
            <footer>
            <p>&copy; <a href="http://sylius.org">Sylius</a>, 2011.</p>
            </footer>
        </div>
    </body>
</html>

<?php 

exit;

endif;

/*
 * Sylius sandbox installer.
 */

// Require autoload.
require_once __DIR__.'/../sylius-sandbox/autoload.php';

// Require kernel.
require_once __DIR__.'/../sylius-sandbox/SandboxKernel.php';

// Initialize kernel and run the application.
$kernel = new \Sylius\SandboxKernel('installer', false);
$kernel->loadClassCache();
$kernel->handle(Request::createFromGlobals())->send();
