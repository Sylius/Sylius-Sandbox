<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Sandbox\Bundle\CoreBundle\Controller\Backend;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Response;

/**
 * Administration dashboard controller.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class MainController extends ContainerAware
{
    /**
     * Displays administration dashboard main panel.
     *
     * @return Response
     */
    public function indexAction()
    {
        return $this->container->get('templating')->renderResponse('SandboxCoreBundle:Backend/Main:index.html.twig');
    }
}
