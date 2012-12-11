<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\SandboxBundle\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Administration dashboard controller.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class MainController extends Controller
{
    /**
     * Displays administration dashboard main panel.
     *
     * @return Response
     */
    public function indexAction()
    {
        $recentOrders = $this
            ->getOrderRepository()
            ->findBy(array(), array('updatedAt' => 'desc'), 5)
        ;

        $topOrders = $this
            ->getOrderRepository()
            ->findBy(array(), array('total' => 'desc'), 5)
        ;


        $newestUsers = $this
            ->getUserRepository()
            ->findBy(array(), array('id' => 'desc'), 10)
        ;

        return $this->render('SyliusSandboxBundle:Backend/Main:index.html.twig', array(
            'recentOrders' => $recentOrders,
            'topOrders'    => $topOrders,
            'newestUsers'  => $newestUsers
        ));
    }

    private function getOrderRepository()
    {
        return $this->get('sylius_sales.repository.order');
    }

    private function getUserRepository()
    {
        return $this->get('sylius_user.repository.user');
    }
}
