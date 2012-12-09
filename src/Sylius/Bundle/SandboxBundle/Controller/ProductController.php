<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\SandboxBundle\Controller;

use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Product controller.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class ProductController extends ResourceController
{
    public function listByTaxonAction(Request $request, $permalink)
    {
        $taxon = $this->findTaxonOr404($permalink);

        $paginator = $this
            ->getRepository()
            ->createByTaxonPaginator($taxon)
        ;

        $paginator->setCurrentPage($request->query->get('page', 1));
        $paginator->setMaxPerPage(9);

        $products = $paginator->getCurrentPageResults();

        return $this->renderResponse('listByTaxon.html', array(
            'taxon'     => $taxon,
            'products'  => $products,
            'paginator' => $paginator
        ));
    }

    private function findTaxonOr404($permalink)
    {
        $criteria = array('permalink' => $permalink);

        if (!$taxon = $this->getTaxonRepository()->findOneBy($criteria)) {
            throw new NotFoundHttpException('Requested taxon does not exist');
        }

        return $taxon;
    }

    private function getTaxonRepository()
    {
        return $this->get('sylius_taxonomies.repository.taxon');
    }
}
