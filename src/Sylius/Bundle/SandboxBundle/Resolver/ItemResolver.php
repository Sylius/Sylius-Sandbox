<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\SandboxBundle\Resolver;

use Doctrine\Common\Persistence\ObjectRepository;
use Sylius\Bundle\AssortmentBundle\Model\Variant\VariantInterface;
use Sylius\Bundle\CartBundle\Model\CartItemInterface;
use Sylius\Bundle\CartBundle\Resolver\ItemResolverInterface;
use Sylius\Bundle\CartBundle\Resolver\ItemResolvingException;
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
     * @var ObjectRepository
     */
    private $productRepository;

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
     * @param ObjectRepository       $productRepository
     * @param FormFactory            $formFactory
     * @param StockResolverInterface $stockResolver
     */
    public function __construct(
        ObjectRepository       $productRepository,
        FormFactory            $formFactory,
        StockResolverInterface $stockResolver
    )
    {
        $this->productRepository = $productRepository;
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
            throw new ItemResolvingException('Error while trying to add item to cart');
        }

        if (!$product = $this->productRepository->find($id)) {
            throw new ItemResolvingException('Requested product was not found');
        }

        if (!$request->isMethod('POST')) {
            throw new ItemResolvingException('Wrong request method');
        }

        // We use forms to easily set the quantity and pick variant but you can do here whatever is required to create the item.
        $form = $this->formFactory->create('sylius_cart_item', null, array('product' => $product));

        $form->bind($request);
        $item = $form->getData(); // Item instance, cool.

        // If our product has no variants, we simply set the master variant of it.
        if (!$product->hasOptions()) {
            $item->setVariant($product->getMasterVariant());
        }

        $variant = $item->getVariant();

        // If all is ok with form, quantity and other stuff, simply return the item.
        if ($form->isValid() && $variant) {
            $this->isInStock($variant);

            return $item;
        }

        throw new ItemResolvingException('Submitted form is invalid');
    }

    private function isInStock(VariantInterface $variant)
    {
        if (!$this->stockResolver->isInStock($variant)) {
            throw new ItemResolvingException('Selected item is out of stock');
        }
    }
}
