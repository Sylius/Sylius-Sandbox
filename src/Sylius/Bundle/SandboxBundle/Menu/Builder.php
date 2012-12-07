<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\SandboxBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Menu builder.
 *
 * @author Саша Стаменковић <umpirsky@gmail.com>
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class Builder extends ContainerAware
{
    /**
     * Builds frontend main menu.
     *
     * @param FactoryInterface $factory
     * @param array            $options
     *
     * @return ItemInterface
     */
    public function frontendMainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', array(
            'childrenAttributes' => array(
                'class' => 'nav'
            )
        ));

        $menu->setCurrent($this->container->get('request')->getRequestUri());

        $menu->addChild('Shop', array('route' => 'sylius_sandbox_core_frontend'));

        $menu->addChild('Products', array('route' => 'sylius_sandbox_product_list'));
        $menu->addChild('Blog', array('route' => 'sylius_sandbox_post_list'));
        $menu->addChild('About', array('route' => 'sylius_sandbox_about'));

        $menu->addChild('My cart', array('route' => 'sylius_cart_show'));

        return $menu;
    }

    /**
     * Builds frontend side menu.
     *
     * @param FactoryInterface $factory
     * @param array            $options
     *
     * @return ItemInterface
     */
    public function frontendSidebarMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', array(
            'childrenAttributes' => array(
                'class' => 'nav'
            )
        ));

        $menu->setCurrent($this->container->get('request')->getRequestUri());

        $childOptions = array(
            'childrenAttributes' => array('class' => 'nav nav-list'),
            'labelAttributes'    => array('class' => 'nav-header')
        );

        $child = $menu->addChild('Sylius', $childOptions);
        $child->addChild('About', array(
            'route'           => 'sylius_sandbox_about',
            'labelAttributes' => array('icon' => 'icon-info-sign')
        ));

        $categoryManager = $this->container->get('sylius_categorizer.manager.category');

        $assortmentCategories = $categoryManager->findCategories('assortment');
        $child = $menu->addChild('Browse products', $childOptions);

        $child->addChild('All products', array(
            'route'           => 'sylius_sandbox_product_list',
            'labelAttributes' => array('icon' => 'icon-tags')
        ));

        foreach ($assortmentCategories as $category) {
            $child->addChild($category['name'], array(
                'route'           => 'sylius_categorizer_category_show',
                'routeParameters' => array(
                    'alias' => 'assortment',
                    'slug'  => $category['slug']
                ),
                'labelAttributes' => array('icon' => 'icon-chevron-right')
            ));
        }

        $blogCategories = $categoryManager->findCategories('blog');
        $child = $menu->addChild('Blog', $childOptions);

        foreach ($blogCategories as $category) {
            $child->addChild($category->getName(), array(
                'route'           => 'sylius_categorizer_category_show',
                'routeParameters' => array(
                    'alias' => 'blog',
                    'slug'  => $category->getSlug()
                ),
                'labelAttributes' => array('icon' => 'icon-chevron-right')
            ));
        }
        
        $child = $menu->addChild('My account', $childOptions);
        if ($this->container->get('security.context')->isGranted('ROLE_USER')) {
            $child->addChild('Logout', array(
                'route' => 'fos_user_security_logout',
                'labelAttributes' => array('icon' => 'icon-off')
            ));
        } else {
            $child->addChild('Register', array(
                'route' => 'fos_user_registration_register',
                'labelAttributes' => array('icon' => 'icon-plus')
            ));
            $child->addChild('Login', array(
                'route' => 'fos_user_security_login',
                'labelAttributes' => array('icon' => 'icon-user')
            ));
        }

        if ($this->container->get('security.context')->isGranted('ROLE_SYLIUS_ADMIN')) {
            $child->addChild('Dashboard', array(
                'route' => 'sylius_sandbox_core_backend',
                'labelAttributes' => array('icon' => 'icon-lock')
            ));
        }

        return $menu;
    }

    /**
     * Builds backend main menu.
     *
     * @param FactoryInterface $factory
     * @param array            $options
     *
     * @return ItemInterface
     */
    public function backendMainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', array(
            'childrenAttributes' => array(
                'class' => 'nav'
            )
        ));

        $menu->setCurrent($this->container->get('request')->getRequestUri());

        $menu->addChild('Dashboard', array('route' => 'sylius_sandbox_core_backend'));

        $childOptions = array(
            'attributes'         => array('class' => 'dropdown'),
            'childrenAttributes' => array('class' => 'dropdown-menu'),
            'labelAttributes'    => array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'href' => '#')
        );

        $this->addAssortmentMenu($menu, $childOptions);
        $this->addSalesMenu($menu, $childOptions);
        $this->addBlogMenu($menu, $childOptions);
        $this->addAddressingMenu($menu, $childOptions);

        $menu->addChild('Go to <strong>frontend</strong>', array('route' => 'sylius_sandbox_core_frontend'));

        return $menu;
    }

    /**
     * Builds backend side menu.
     *
     * @param FactoryInterface $factory
     * @param array            $options
     *
     * @return ItemInterface
     */
    public function backendSidebarMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', array(
            'childrenAttributes' => array(
                'class' => 'nav'
            )
        ));

        $menu->setCurrent($this->container->get('request')->getRequestUri());

        $childOptions = array(
            'childrenAttributes' => array('class' => 'nav nav-list'),
            'labelAttributes'    => array('class' => 'nav-header')
        );

        $this->addAssortmentMenu($menu, $childOptions);
        $this->addSalesMenu($menu, $childOptions);
        $this->addBlogMenu($menu, $childOptions);
        $this->addAddressingMenu($menu, $childOptions);

        $child = $menu->addChild('Administration', $childOptions);
        $child->addChild('Logout', array(
            'route' => 'fos_user_security_logout',
            'labelAttributes' => array('icon' => 'icon-off')
        ));

        return $menu;
    }

    /**
     * Adds assortment menu.
     *
     * @param ItemInterface $menu
     * @param array         $childOptions
     */
    protected function addAssortmentMenu(ItemInterface $menu, array $childOptions)
    {
        $child = $menu->addChild('Assortment', $childOptions);

        // Categories.
        $child->addChild('Create category', array(
            'route'           => 'sylius_categorizer_backend_category_create',
            'routeParameters' => array('alias' => 'assortment'),
            'labelAttributes' => array('icon' => 'icon-plus-sign')
        ));
        $child->addChild('List categories', array(
            'route'           => 'sylius_categorizer_backend_category_list',
            'routeParameters' => array('alias' => 'assortment'),
            'labelAttributes' => array('icon' => 'icon-list-alt')
        ));

        $this->addDivider($child);

        // Products.
        $child->addChild('Create product', array(
            'route'           => 'sylius_sandbox_backend_product_create',
            'labelAttributes' => array('icon' => 'icon-plus-sign')
        ));
        $child->addChild('List products', array(
            'route'           => 'sylius_sandbox_backend_product_list',
            'labelAttributes' => array('icon' => 'icon-list-alt')
        ));

        $this->addDivider($child);

        // Option types.
        $child->addChild('Create option', array(
            'route'           => 'sylius_sandbox_backend_option_create',
            'labelAttributes' => array('icon' => 'icon-plus-sign')
        ));
        $child->addChild('List options', array(
            'route'           => 'sylius_sandbox_backend_option_list',
            'labelAttributes' => array('icon' => 'icon-list-alt')
        ));

        $this->addDivider($child);

        // Properties.
        $child->addChild('Create property', array(
            'route'           => 'sylius_sandbox_backend_property_create',
            'labelAttributes' => array('icon' => 'icon-plus-sign')
        ));
        $child->addChild('List properties', array(
            'route'           => 'sylius_sandbox_backend_property_list',
            'labelAttributes' => array('icon' => 'icon-list-alt')
        ));

        $this->addDivider($child);

        // Prototypes.
        $child->addChild('Create prototype', array(
            'route'           => 'sylius_sandbox_backend_prototype_create',
            'labelAttributes' => array('icon' => 'icon-plus-sign')
        ));
        $child->addChild('List prototypes', array(
            'route'           => 'sylius_sandbox_backend_prototype_list',
            'labelAttributes' => array('icon' => 'icon-list-alt')
        ));
    }

    /**
     * Adds sales menu.
     *
     * @param ItemInterface $menu
     * @param array         $childOptions
     */
    protected function addSalesMenu(ItemInterface $menu, array $childOptions)
    {
        $child = $menu->addChild('Sales', $childOptions);

        $child->addChild('Current orders', array(
            'route'           => 'sylius_sandbox_backend_order_list',
            'labelAttributes' => array('icon' => 'icon-list-alt')
        ));
        $child->addChild('Create order', array(
            'route'           => 'sylius_sandbox_backend_order_create',
            'labelAttributes' => array('icon' => 'icon-plus-sign')
        ));
    }
    
    /**
     * Adds blog menu.
     *
     * @param ItemInterface $menu
     * @param array         $childOptions
     */
    protected function addBlogMenu(ItemInterface $menu, array $childOptions)
    {
        $child = $menu->addChild('Blog', $childOptions);

        $child->addChild('Create category', array(
            'route'           => 'sylius_categorizer_backend_category_create',
            'routeParameters' => array('alias' => 'blog'),
            'labelAttributes' => array('icon' => 'icon-plus-sign')
        ));
        $child->addChild('List categories', array(
            'route'           => 'sylius_categorizer_backend_category_list',
            'routeParameters' => array('alias' => 'blog'),
            'labelAttributes' => array('icon' => 'icon-list-alt')
        ));

        $this->addDivider($child);

        $child->addChild('Create post', array(
            'route' => 'sylius_sandbox_backend_post_create',
            'labelAttributes' => array('icon' => 'icon-plus-sign')
        ));
        $child->addChild('List posts', array(
            'route'           => 'sylius_sandbox_backend_post_list',
            'labelAttributes' => array('icon' => 'icon-list-alt')
        ));
    }

    /**
     * Adds addressing menu.
     *
     * @param ItemInterface $menu
     * @param array         $childOptions
     */
    protected function addAddressingMenu(ItemInterface $menu, array $childOptions)
    {
        $child = $menu->addChild('Address book', $childOptions);

        $child->addChild('Create address', array(
            'route' => 'sylius_sandbox_backend_address_create',
            'labelAttributes' => array('icon' => 'icon-plus-sign')
        ));
        $child->addChild('List addresses', array(
            'route' => 'sylius_sandbox_backend_address_list',
            'labelAttributes' => array('icon' => 'icon-list-alt')
        ));
    }

    /**
     * Adds divider menu item.
     *
     * @param ItemInterface $item
     * @param Boolean       $vertical
     */
    protected function addDivider(ItemInterface $item, $vertical = false)
    {
        $item->addChild(uniqid(), array(
            'attributes' => array(
                'class' => $vertical ? 'divider-vertical' : 'divider',
                'label' => ''
            )
        ));
    }
}
