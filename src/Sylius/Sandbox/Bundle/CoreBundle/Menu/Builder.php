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
use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Menu builder.
 *
 * @author Саша Стаменковић <umpirsky@gmail.com>
 */
class Builder extends ContainerAware
{
    /**
     * Builds backend main menu.
     *
     * @param FactoryInterface $factory
     * @param array $options
     * @return \Knp\Menu\ItemInterface
     */
    public function backendMainMenu(FactoryInterface $factory, array $options)
    {
        $childOptions = array(
            'attributes' => array('class' => 'dropdown'),
            'childrenAttributes' => array('class' => 'dropdown-menu'),
            'labelAttributes' => array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'href' => '#')
        );
        $dividerOptions = array('attributes' => array('class' => 'divider'));

        $menu = $factory->createItem('root', array('childrenAttributes' => array('class' => 'nav')));
        $menu->setCurrentUri($this->container->get('request')->getRequestUri());
        $menu->addChild('menu.dashboard', array('route' => 'sylius_sandbox_core_backend'));

        $child = $menu->addChild('menu.assortment', $childOptions);
        $child->addChild('menu.backend.category_create', array('route' => 'sylius_categorizer_backend_category_create', 'routeParameters' => array('alias' => 'assortment')));
        $child->addChild('menu.backend.category_list', array('route' => 'sylius_categorizer_backend_category_list', 'routeParameters' => array('alias' => 'assortment')));
        $child->addChild('category_divider', $dividerOptions);
        $child->addChild('menu.backend.product_create', array('route' => 'sylius_assortment_backend_product_create'));
        $child->addChild('menu.backend.product_list', array('route' => 'sylius_assortment_backend_product_list'));
        $child->addChild('product_divider', $dividerOptions);
        $child->addChild('menu.backend.option_create', array('route' => 'sylius_assortment_backend_option_create'));
        $child->addChild('menu.backend.option_list', array('route' => 'sylius_assortment_backend_option_list'));
        $child->addChild('option_divider', $dividerOptions);
        $child->addChild('menu.backend.property_create', array('route' => 'sylius_assortment_backend_property_create'));
        $child->addChild('menu.backend.property_list', array('route' => 'sylius_assortment_backend_property_list'));
        $child->addChild('property_divider', $dividerOptions);
        $child->addChild('menu.backend.prototype_create', array('route' => 'sylius_assortment_backend_prototype_create'));
        $child->addChild('menu.backend.prototype_list', array('route' => 'sylius_assortment_backend_prototype_list'));

        $child = $menu->addChild('menu.sales', $childOptions);
        $child->addChild('menu.backend.order_list', array('route' => 'sylius_sales_backend_order_list'));
        $child->addChild('divider', $dividerOptions);
        $child->addChild('menu.backend.status_list', array('route' => 'sylius_sales_backend_status_list'));

        $child = $menu->addChild('menu.blog', $childOptions);
        $child->addChild('menu.backend.category_create', array('route' => 'sylius_categorizer_backend_category_create', 'routeParameters' => array('alias' => 'blog')));
        $child->addChild('menu.backend.category_list', array('route' => 'sylius_categorizer_backend_category_list', 'routeParameters' => array('alias' => 'blog')));
        $child->addChild('divider', $dividerOptions);
        $child->addChild('menu.backend.post_create', array('route' => 'sylius_blogger_backend_post_create'));
        $child->addChild('menu.backend.post_list', array('route' => 'sylius_blogger_backend_post_list'));

        $child = $menu->addChild('menu.addressing', $childOptions);
        $child->addChild('menu.backend.address_create', array('route' => 'sylius_addressing_backend_address_create'));
        $child->addChild('divider', $dividerOptions);
        $child->addChild('menu.backend.address_list', array('route' => 'sylius_addressing_backend_address_list'));

        $child = $menu->addChild('menu.frontend', array('route' => 'sylius_sandbox_core_frontend'));

        return $menu;
    }
}
