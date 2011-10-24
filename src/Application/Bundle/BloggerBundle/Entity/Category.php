<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Bundle\BloggerBundle\Entity;

use Sylius\Bundle\CatalogBundle\Entity\Category as BaseCategory;

class Category extends BaseCategory
{
    protected $posts;
    
    public function getPosts($posts)
    {
        return $this->posts;
    }
    
    public function setPosts($posts)
    {
        $this->posts = $posts;
    }
}
