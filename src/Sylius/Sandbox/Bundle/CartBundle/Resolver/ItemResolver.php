<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Sandbox\Bundle\CartBundle\Resolver;

use Sylius\Bundle\AssortmentBundle\Model\ProductManagerInterface;
use Sylius\Bundle\CartBundle\Model\ItemManagerInterface;
use Sylius\Bundle\CartBundle\Resolver\ItemResolverInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;

/**
 * Item resolver for cart bundle.
 * Returns proper item objects for cart add and remove actions.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class ItemResolver implements ItemResolverInterface
{
    /**
     * Item manager.
     *
     * @var ItemManagerInterface
     */
    private $itemManager;

    /**
     * Product manager.
     *
     * @var ProductManagerInterface
     */
    private $productManager;

    /**
     * Form factory.
     *
     * @var FormFactory
     */
    private $formFactory;

    /**
     * Constructor.
     *
     * @param ItemManagerInterface    $itemManager
     * @param ProductManagerInterface $productManager
     */
    public function __construct(ItemManagerInterface $itemManager, ProductManagerInterface $productManager, FormFactory $formFactory)
    {
        $this->itemManager = $itemManager;
        $this->productManager = $productManager;
        $this->formFactory = $formFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function resolveItemToAdd(Request $request)
    {
        /*
         * We're getting here product id via query but you can easily override route
         * pattern and use attributes, which are available through request object.
         */
        if ($id = $request->query->get('id')) {
            if ($product = $this->productManager->findProduct($id)) {
                /*
                 * To have it flexible, we allow adding single item by GET request
                 * and also user can provide desired quantity by form via POST request.
                 */
                $item = $this->itemManager->createItem();
                $item->setProduct($product);

                if ('POST' === $request->getMethod()) {
                    $form = $this->formFactory->create('sylius_cart_item');
                    $form->setData($item);
                    $form->bindRequest($request);

                    if (!$form->isValid()) {

                        return false;
                    }
                }

                return $item;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function resolveItemToRemove(Request $request)
    {
        if ($id = $request->query->get('id')) {
            return $this->itemManager->findItem($id);
        }
    }
}
