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
 * Testing environment.
 */

// Require autoload.
require_once __DIR__.'/../sandbox/autoload.php';

// Require kernel.
require_once __DIR__.'/../sandbox/SandboxKernel.php';

// Initialize kernel and run the application.
$kernel = new \Sylius\SandboxKernel('testing', true);
$kernel->handle(Request::createFromGlobals())->send();
