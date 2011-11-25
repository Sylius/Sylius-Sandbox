<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Sandbox\Bundle\CoreBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Frontend controller.
 * 
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class FrontendController extends ContainerAware
{
    /**
     * Front page, yay!
     */
    public function indexAction()
    {
        return $this->container->get('templating')->renderResponse('SandboxCoreBundle:Frontend:index.html.twig');
    }
}
