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
 * Administration dashboard controller.
 * 
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class BackendController extends ContainerAware
{
    /**
     * Displays administration dashboard main panel.
     */
    public function indexAction()
    {
        return $this->container->get('templating')->renderResponse('SandboxCoreBundle:Backend:index.html.twig');
    }
}
