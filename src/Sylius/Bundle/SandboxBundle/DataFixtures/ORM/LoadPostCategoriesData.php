<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\SandboxBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

/**
 * Default blog categories to play with Sylius sandbox.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 * @author Саша Стаменковић <umpirsky@gmail.com>
 */
class LoadPostCategoriesData extends DataFixture
{
    private $manager;
    private $manipulator;
    private $catalog;

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->manager = $this->get('sylius_categorizer.manager.category');
        $this->manipulator = $this->get('sylius_categorizer.manipulator.category');
        $this->catalog = $this->get('sylius_categorizer.registry')->getCatalog('blog');

        $this->createCategory('Symfony2');
        $this->createCategory('Doctrine');
        $this->createCategory('Sylius');
        $this->createCategory('Composer');
    }

    /**
     * Create and save category.
     *
     * @param string $name
     */
    private function createCategory($name)
    {
        $category = $this->manager->createCategory($this->catalog);
        $category->setName($name);

        $this->manipulator->create($category);
        $this->setReference('Sandbox.Blogger.Category.'.$name, $category);
    }

    public function getOrder()
    {
        return 2;
    }
}

