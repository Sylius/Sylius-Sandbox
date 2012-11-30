<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\SandboxBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Frontend main controller.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class MainController extends Controller
{
    /**
     * Fronte page with newest products.
     *
     * @return Response
     */
    public function indexAction()
    {
        $recentProducts = $this
            ->getProductRepository()
            ->findBy(array(), array('updatedAt' => 'desc'), 8)
        ;

        return $this->render('SyliusSandboxBundle:Frontend/Main:index.html.twig', array(
            'recentProducts' => $recentProducts,
        ));
    }

    public function aboutAction()
    {
        return $this->render('SyliusSandboxBundle:Frontend/Main:about.html.twig');
    }

    private function getProductRepository()
    {
        return $this->get('sylius_assortment.repository.product');
    }
}
