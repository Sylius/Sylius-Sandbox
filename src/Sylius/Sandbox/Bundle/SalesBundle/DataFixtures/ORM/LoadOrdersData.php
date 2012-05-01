<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Sandbox\Bundle\SalesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Sylius\Bundle\SalesBundle\Model\OrderInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Builds some simple orders to play with Sylius sandbox.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class LoadOrdersData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $manager = $this->container->get('sylius_sales.manager.order');
        $processor = $this->container->get('sylius_sales.processor');
        $manipulator = $this->container->get('sylius_sales.manipulator.order');

        foreach (range(0, 29) as $i) {
            $order = $manager->createOrder();
            $this->buildOrder($order);

            $manipulator->create($order);
            $this->setReference('Sandbox.Sales.Order-' . $i, $order);
        }
    }

    /**
     * Creates sample cart for order.
     *
     * @param OrderInterface $order
     */
    private function buildOrder(OrderInterface $order)
    {
        $cartManager = $this->container->get('sylius_cart.manager.cart');
        $itemManager = $this->container->get('sylius_cart.manager.item');

        $cartOperator = $this->container->get('sylius_cart.operator');

        $cart = $cartManager->createCart();

        $variants = SYLIUS_ASSORTMENT_FIXTURES_TV;

        foreach (range(0, rand(1, 6)) as $i) {
            $item = $itemManager->createItem();
            $item->setQuantity(rand(1, 5));
            $item->setVariant($this->getReference('Sandbox.Assortment.Variant-'.rand(0, $variants - 1)));

            $cartOperator->addItem($cart, $item);
        }

        $cartOperator->refresh($cart);
        $cartOperator->save($cart);

        $cart->setLocked(true);

        $order->setCart($cart);
        $order->setAddress($this->getReference('Sandbox.Addressing.Address-'.rand(0, 49)));
        $order->setValue($cart->getValue());

        $order->setStatus($this->getReference('Sandbox.Sales.Status-'.rand(0, 5)));
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 9;
    }
}
