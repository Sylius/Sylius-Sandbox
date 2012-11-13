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

        for ($i = 1; $i <= 100; $i++) {
            $order = $manager->createOrder();
            $this->buildOrder($order);

            $manipulator->create($order);
            $this->setReference('Sandbox.Sales.Order-'.$i, $order);
        }
    }

    /**
     * Creates sample cart for order.
     *
     * @param OrderInterface $order
     */
    private function buildOrder(OrderInterface $order)
    {
        $itemManager = $this->container->get('sylius_sales.manager.item');
        $totalVariants = SYLIUS_ASSORTMENT_FIXTURES_TV;

        $totalItems = rand(3, 6);
        for ($i = 0; $i <= $totalItems; $i++) {
            $variant = $this->getReference('Sandbox.Assortment.Variant-'.rand(1, $totalVariants - 1));

            $item = $itemManager->createItem();
            $item->setQuantity(rand(1, 5));
            $item->setVariant($variant);
            $item->setUnitPrice($variant->getPrice());

            $order->addItem($item);
        }

        $order->setDeliveryAddress($this->getReference('Sandbox.Addressing.Address-'.rand(1, 50)));
        $order->setBillingAddress($this->getReference('Sandbox.Addressing.Address-'.rand(1, 50)));

        $order->calculateTotal();

        $order->setStatus($this->getReference('Sandbox.Sales.Status-'.rand(1, 6)));
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 10;
    }
}
