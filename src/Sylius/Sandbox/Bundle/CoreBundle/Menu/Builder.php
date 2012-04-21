<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Sandbox\Bundle\CoreBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Menu builder.
 *
 * @author Саша Стаменковић <umpirsky@gmail.com>
 */
class Builder extends ContainerAware
{
    /**
     * Main menu default child options.
     *
     * @var array
     */
    protected $mainMenuChildOptions = array(
        'attributes' => array('class' => 'dropdown'),
        'childrenAttributes' => array('class' => 'dropdown-menu'),
        'labelAttributes' => array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'href' => '#')
    );

    /**
     * Builds frontend main menu.
     *
     * @param FactoryInterface  $factory
     * @param array             $options
     * @return ItemInterface
     */
    public function frontendMainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', array('childrenAttributes' => array('class' => 'nav')));
        $menu->setCurrentUri($this->container->get('request')->getRequestUri());

        $menu->addChild('menu.frontend.index', array('route' => 'sylius_sandbox_core_frontend'));

        $child = $menu->addChild('menu.frontend.assortment', $this->mainMenuChildOptions);
        $child->addChild('menu.frontend.product_list', array('route' => 'sylius_assortment_product_list'));

        $child = $menu->addChild('menu.frontend.blog', $this->mainMenuChildOptions);
        $child->addChild('menu.frontend.post_list', array('route' => 'sylius_blogger_post_list'));

        $child = $menu->addChild('menu.frontend.my_cart', array('route' => 'sylius_cart_show'));

        return $menu;
    }

    /**
     * Builds backend main menu.
     *
     * @param FactoryInterface  $factory
     * @param array             $options
     * @return ItemInterface
     */
    public function backendMainMenu(FactoryInterface $factory, array $options)
    {
        return $this->backendMenu($factory, $this->mainMenuChildOptions, true);
    }

    /**
     * Builds backend side menu.
     *
     * @param FactoryInterface  $factory
     * @param array             $options
     * @return ItemInterface
     */
    public function backendSideMenu(FactoryInterface $factory, array $options)
    {
        $menu = $this->backendMenu($factory, array('labelAttributes' => array('class' => 'nav-header')), false);

        return $menu;
    }

    /**
     * Builds backend menu.
     *
     * @param FactoryInterface  $factory
     * @param array             $childOptions
     * @param bool              $isMain         true for main menu, false for side
     * @return ItemInterface
     */
    protected function backendMenu(FactoryInterface $factory, array $childOptions, $isMain)
    {
        $menu = $factory->createItem('root', array('childrenAttributes' => array('class' => 'nav' . ($isMain ? '' : ' nav-list'))));
        $menu->setCurrentUri($this->container->get('request')->getRequestUri());

        $menu->addChild('menu.backend.dashboard', array('route' => 'sylius_sandbox_core_backend'));

        $child = $menu->addChild('menu.backend.assortment', $childOptions);
        $child->addChild('menu.backend.category_create', array('route' => 'sylius_categorizer_backend_category_create', 'routeParameters' => array('alias' => 'assortment')));
        $child->addChild('menu.backend.category_list', array('route' => 'sylius_categorizer_backend_category_list', 'routeParameters' => array('alias' => 'assortment')));
        $this->addDivider($child, 'category_divider', $isMain);
        $child->addChild('menu.backend.product_create', array('route' => 'sylius_assortment_backend_product_create'));
        $child->addChild('menu.backend.product_list', array('route' => 'sylius_assortment_backend_product_list'));
        $this->addDivider($child, 'product_divider', $isMain);
        $child->addChild('menu.backend.option_create', array('route' => 'sylius_assortment_backend_option_create'));
        $child->addChild('menu.backend.option_list', array('route' => 'sylius_assortment_backend_option_list'));
        $this->addDivider($child, 'option_divider', $isMain);
        $child->addChild('menu.backend.property_create', array('route' => 'sylius_assortment_backend_property_create'));
        $child->addChild('menu.backend.property_list', array('route' => 'sylius_assortment_backend_property_list'));
        $this->addDivider($child, 'property_divider', $isMain);
        $child->addChild('menu.backend.prototype_create', array('route' => 'sylius_assortment_backend_prototype_create'));
        $child->addChild('menu.backend.prototype_list', array('route' => 'sylius_assortment_backend_prototype_list'));

        $child = $menu->addChild('menu.backend.sales', $childOptions);
        $child->addChild('menu.backend.order_list', array('route' => 'sylius_sales_backend_order_list'));
        $this->addDivider($child, 'divider', $isMain);
        $child->addChild('menu.backend.status_list', array('route' => 'sylius_sales_backend_status_list'));

        $child = $menu->addChild('menu.backend.blog', $childOptions);
        $child->addChild('menu.backend.category_create', array('route' => 'sylius_categorizer_backend_category_create', 'routeParameters' => array('alias' => 'blog')));
        $child->addChild('menu.backend.category_list', array('route' => 'sylius_categorizer_backend_category_list', 'routeParameters' => array('alias' => 'blog')));
        $this->addDivider($child, 'divider', $isMain);
        $child->addChild('menu.backend.post_create', array('route' => 'sylius_blogger_backend_post_create'));
        $child->addChild('menu.backend.post_list', array('route' => 'sylius_blogger_backend_post_list'));

        $child = $menu->addChild('menu.backend.addressing', $childOptions);
        $child->addChild('menu.backend.address_create', array('route' => 'sylius_addressing_backend_address_create'));
        $this->addDivider($child, 'divider', $isMain);
        $child->addChild('menu.backend.address_list', array('route' => 'sylius_addressing_backend_address_list'));

        if ($isMain) {
            $child = $menu->addChild('menu.backend.frontend', array('route' => 'sylius_sandbox_core_frontend'));
        } else {
            $child = $menu->addChild('sidebar.menu.administration', $childOptions);
            $child->addChild('menu.backend.logout', array('route' => 'sylius_sandbox_core_frontend_security_logout'));
        }

        return $menu;
    }

    /**
     * Adds divider menu item.
     *
     * @param ItemInterface $item
     * @param string        $name   name of a new item to create
     * @param bool          $add    add divider only if this parameter is true
     */
    protected function addDivider(ItemInterface $item, $name, $add)
    {
        if (!$add) {
            return;
        }

        $item->addChild($name, array('attributes' => array('class' => 'divider')));
    }
}
