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

/*
 * Sylius sandbox front controller.
 * Dev environment.
 */

if (!in_array(@$_SERVER['REMOTE_ADDR'], array(
    '127.0.0.1',
    '::1',
))) {
    header('HTTP/1.0 403 Forbidden');
    exit('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
}

// Require kernel.
require_once __DIR__.'/../sandbox/SandboxKernel.php';

// Initialize kernel and run the application.
$kernel = new \Sylius\SandboxKernel('dev', true);
$kernel->handle(Request::createFromGlobals())->send();
