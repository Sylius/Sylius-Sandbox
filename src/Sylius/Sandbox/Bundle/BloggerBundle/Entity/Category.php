<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Sandbox\Bundle\BloggerBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Bundle\CategorizerBundle\Entity\Category as BaseCategory;

/**
 * Blog category.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class Category extends BaseCategory
{
    /**
     * @var Collection
     */
    private $posts;

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->posts = new ArrayCollection;
    }

    /**
     * Get posts.
     *
     * @return Collection
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * Set posts.
     *
     * @param Collection $posts
     */
    public function setPosts(Collection $posts)
    {
        $this->posts = $posts;
    }
}
