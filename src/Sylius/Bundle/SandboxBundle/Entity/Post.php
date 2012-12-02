<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\SandboxBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Sylius\Bundle\BloggerBundle\Entity\Post as BasePost;

/**
 * Categorized blog post.
 *
 * @author Paweł Jędrzejewski <pjedrzjeewksi@diweb.pl>
 * @author Саша Стаменковић <umpirsky@gmail.com>
 */
class Post extends BasePost
{
    /**
     * @var Collection
     */
    private $categories;

    /**
     * Get categories.
     *
     * @return Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set categories.
     *
     * @param Collection $categories
     */
    public function setCategories(Collection $categories)
    {
        $this->categories = $categories;
    }

    /**
     * Get comment thread ID.
     *
     * @return string
     */
    public function getCommentThreadId()
    {
        return 'blogger_post_'.$this->getId();
    }
}
