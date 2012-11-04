<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Sandbox\Bundle\CoreBundle\Resolver;

use Sylius\Bundle\AssortmentBundle\Model\ProductManagerInterface;
use Sylius\Bundle\CartBundle\Model\CartItemInterface;
use Sylius\Bundle\CartBundle\Resolver\ItemResolverInterface;
use Sylius\Bundle\InventoryBundle\Resolver\StockResolverInterface;
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
     * Stock resolver.
     *
     * @var StockResolverInterface
     */
    private $stockResolver;

    /**
     * Constructor.
     *
     * @param ProductManagerInterface $productManager
     * @param FormFactory             $formFactory
     * @param StockResolverInterface  $stockResolver
     */
    public function __construct(
        ProductManagerInterface $productManager,
        FormFactory             $formFactory,
        StockResolverInterface  $stockResolver
    )
    {
        $this->productManager = $productManager;
        $this->formFactory = $formFactory;
        $this->stockResolver = $stockResolver;
    }

    /**
     * {@inheritdoc}
     *
     * Here we create the item that is going to be added to cart, basing on the current request.
     * This method simply has to return false value if something is wrong.
     */
    public function resolve(CartItemInterface $item, Request $request)
    {
        /*
         * We're getting here product id via query but you can easily override route
         * pattern and use attributes, which are available through request object.
         */
        if (!$id = $request->query->get('id')) {

            return false;
        }

        if (!$product = $this->productManager->findProduct($id)) {
            throw new NotFoundHttpException('Requested product does not exist');
        }

        // We use forms to easily set the quantity and pick variant but you can do here whatever is required to create the item.
        if ('POST' === $request->getMethod()) {
            $form = $this->formFactory->create('sylius_cart_item', null, array('product' => $product));

            $form->bindRequest($request);
            $item = $form->getData(); // Item instance, cool.

            // If our product has no variants, we simply set the master variant of it.
            if (0 === $product->countVariants()) {
                $item->setVariant($product->getMasterVariant());
            }

            $variant = $item->getVariant();

            // If all is ok with form, quantity and other stuff, simply return the item.
            if ($form->isValid() && $variant && $this->stockResolver->isInStock($variant)) {

                return $item;
            }
        }
    }
}
