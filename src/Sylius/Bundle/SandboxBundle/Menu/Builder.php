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

        $childOptions = array(
            'attributes'         => array('class' => 'dropdown'),
            'childrenAttributes' => array('class' => 'dropdown-menu'),
            'labelAttributes'    => array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'href' => '#')
        );

        $categoryManager = $this->container->get('sylius_categorizer.manager.category');
        $blogCategories = $categoryManager->findCategories('blog');

        $child = $menu->addChild('Blog', $childOptions);
        $child->addChild('Latest posts', array('route' => 'sylius_sandbox_post_list'));
        $this->addDivider($child);

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

        $child = $menu->addChild('Browse products', $childOptions);

        $child->addChild('All products', array(
            'route'           => 'sylius_sandbox_product_list',
            'labelAttributes' => array('icon' => 'icon-tags')
        ));

        $taxonomies = $this
            ->getTaxonomyRepository()
            ->findAll()
        ;

        foreach ($taxonomies as $taxonomy) {
            $child = $menu->addChild($taxonomy->getName(), $childOptions);

            foreach ($taxonomy->getTaxons() as $taxon) {
                $child->addChild($taxon->getName(), array(
                    'route'           => 'sylius_sandbox_product_list_by_taxon',
                    'routeParameters' => array('permalink' => $taxon->getPermalink()),
                    'labelAttributes' => array('icon' => ' icon-caret-right')
                ));
            }
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

        $this->addTaxonomiesMenu($menu, $childOptions);
        $this->addAssortmentMenu($menu, $childOptions);
        $this->addSalesMenu($menu, $childOptions);
        $this->addCustomersMenu($menu, $childOptions);
        $this->addConfigurationMenu($menu, $childOptions);
        $this->addBlogMenu($menu, $childOptions);

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

        $this->addTaxonomiesMenu($menu, $childOptions);
        $this->addAssortmentMenu($menu, $childOptions);
        $this->addSalesMenu($menu, $childOptions);
        $this->addCustomersMenu($menu, $childOptions);
        $this->addConfigurationMenu($menu, $childOptions);

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
     * Adds customers menu.
     *
     * @param ItemInterface $menu
     * @param array         $childOptions
     */
    protected function addCustomersMenu(ItemInterface $menu, array $childOptions)
    {
        $child = $menu->addChild('Customers', $childOptions);

        $child->addChild('Address book', array(
            'route' => 'sylius_sandbox_backend_address_list',
            'labelAttributes' => array('icon' => 'icon-list-alt')
        ));
        $child->addChild('New address', array(
            'route' => 'sylius_sandbox_backend_address_create',
            'labelAttributes' => array('icon' => 'icon-plus-sign')
        ));
        $child->addChild('User list', array(
            'route' => 'sylius_sandbox_backend_user_list',
            'labelAttributes' => array('icon' => 'icon-user')
        ));
    }

    /**
     * Adds taxonomies menu.
     *
     * @param ItemInterface $menu
     * @param array         $childOptions
     */
    protected function addTaxonomiesMenu(ItemInterface $menu, array $childOptions)
    {
        $child = $menu->addChild('Categorization', $childOptions);

        $child->addChild('Create taxonomy', array(
            'route' => 'sylius_sandbox_backend_taxonomy_create',
            'labelAttributes' => array('icon' => 'icon-plus-sign')
        ));
        $child->addChild('List taxonomies', array(
            'route' => 'sylius_sandbox_backend_taxonomy_list',
            'labelAttributes' => array('icon' => 'icon-list-alt')
        ));
    }

    /**
     * Adds configuration menu.
     *
     * @param ItemInterface $menu
     * @param array         $childOptions
     */
    protected function addConfigurationMenu(ItemInterface $menu, array $childOptions)
    {
        $child = $menu->addChild('Configuration', $childOptions);

        $child->addChild('Manage countries and provinces', array(
            'route' => 'sylius_sandbox_backend_country_list',
            'labelAttributes' => array('icon' => 'icon-globe')
        ));
        $child->addChild('Manage zones', array(
            'route' => 'sylius_sandbox_backend_zone_list',
            'labelAttributes' => array('icon' => 'icon-globe')
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

    private function getTaxonomyRepository()
    {
        return $this->container->get('sylius_taxonomies.repository.taxonomy');
    }
}
