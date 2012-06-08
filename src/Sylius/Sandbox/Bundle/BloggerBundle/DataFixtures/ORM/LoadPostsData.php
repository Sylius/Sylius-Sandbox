<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Sandbox\Bundle\BloggerBundle\DataFixtures\ORM;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Faker\Factory as FakerFactory;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Default blog posts to play with Sylius sandbox.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class LoadPostsData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    /**
     * Container.
     *
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
        $manager = $this->container->get('sylius_blogger.manager.post');
        $manipulator = $this->container->get('sylius_blogger.manipulator.post');

        $faker = FakerFactory::create();
        $categoriesA = array('Symfony2', 'Sylius');
        $categoriesB = array('Doctrine', 'Composer');

        for ($i = 1; $i <= 50; $i++) {
            $post = $manager->createPost();

            $post->setTitle($faker->sentence);
            $post->setAuthor($faker->name);
            $post->setContent($faker->paragraph);

            $randomA = $faker->randomElement($categoriesA);
            $randomB = $faker->randomElement($categoriesB);

            $categories = array(
                $this->getReference('Sandbox.Blogger.Category.'.$randomA),
                $this->getReference('Sandbox.Blogger.Category.'.$randomB)
            );

            $post->setCategories(new ArrayCollection($categories));

            $manipulator->create($post);
            $this->setReference('Sandbox.Blogger.Post-'.$i, $post);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 8;
    }
}
