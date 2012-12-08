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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Default blog posts to play with Sylius sandbox.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 * @author Саша Стаменковић <umpirsky@gmail.com>
 */
class LoadPostsData extends DataFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $categoriesA = array('Symfony2', 'Sylius');
        $categoriesB = array('Doctrine', 'Composer');

        for ($i = 1; $i <= 50; $i++) {
            $post = $this->get('sylius_blogger.repository.post')->createNew();

            $post->setTitle($this->faker->sentence);
            $post->setAuthor($this->faker->name);
            $post->setContent($this->faker->paragraph(9));

            $randomA = $this->faker->randomElement($categoriesA);
            $randomB = $this->faker->randomElement($categoriesB);

            $categories = array(
                $this->getReference('Sandbox.Blogger.Category.'.$randomA),
                $this->getReference('Sandbox.Blogger.Category.'.$randomB)
            );

            $post->setCategories(new ArrayCollection($categories));

            $manager->persist($post);

            $this->setReference('Sandbox.Blogger.Post-'.$i, $post);

            if (0 === $i % 20) {
                $manager->flush();
            }
        }

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 10;
    }
}
