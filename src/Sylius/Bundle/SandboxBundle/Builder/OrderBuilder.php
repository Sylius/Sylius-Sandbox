<?php

namespace Sylius\Bundle\SandboxBundle\Builder;

use Doctrine\Common\Persistence\ObjectRepository;
use Sylius\Bundle\SalesBundle\Builder\OrderBuilder as BaseOrderBuilder;
use Sylius\Bundle\SalesBundle\Model\OrderInterface;
use Sylius\Bundle\CartBundle\Provider\CartProviderInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Order builder.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class OrderBuilder extends BaseOrderBuilder
{
    private $cartProvider;
    private $securityContext;

    public function __construct(ObjectRepository $orderItemRepository, CartProviderInterface $cartProvider, SecurityContextInterface $securityContext)
    {
        $this->cartProvider = $cartProvider;
        $this->securityContext = $securityContext;

        parent::__construct($orderItemRepository);
    }

    /**
     * {@inheritdoc}
     */
    public function build(OrderInterface $order)
    {
        $order->getItems()->clear();

        $cart = $this->cartProvider->getCart();

        if ($cart->isEmpty()) {
            throw new \LogicException('The cart must not be empty.');
        }

        $order->setUser($this->securityContext->getToken()->getUser());

        foreach ($cart->getItems() as $item) {
            $orderItem = $this->createNewItem();

            $orderItem->setVariant($item->getVariant());
            $orderItem->setQuantity($item->getQuantity());
            $orderItem->setUnitPrice($item->getVariant()->getPrice());

            $order->addItem($orderItem);
        }

        $order->calculateTotal();
    }
}
