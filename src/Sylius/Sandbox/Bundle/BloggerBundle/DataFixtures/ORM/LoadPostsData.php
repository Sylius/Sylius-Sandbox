<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Sandbox\Bundle\AssortmentBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * Default blog posts to play with Sylius sandbox.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class LoadPostsData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $manager = $this->container->get('sylius_blogger.manager.post');
        $manipulator = $this->container->get('sylius_blogger.manipulator.post');

        $faker = \Faker\Factory::create();

        foreach (range(0, 50) as $i) {
            $post = $manager->createPost();

            $post->setTitle($faker->sentence);
            $post->setAuthor($faker->name);
            $post->setContent($faker->paragraph);

            $categories = array(
                $this->getReference('Sandbox.PostCategory-' . rand(0, 5)),
                $this->getReference('Sandbox.PostCategory-' . rand(6, 10))
            );

            $post->setCategories($categories);

            $manipulator->create($post);

            $this->setReference('Sandbox.Post-' . $i, $post);
        }
    }

    public function getOrder()
    {
        return 5;
    }
}