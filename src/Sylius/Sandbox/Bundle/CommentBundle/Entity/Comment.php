<?php

/*
* This file is part of the Sylius sandbox application.
*
* (c) Paweł Jędrzejewski
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Sylius\Sandbox\Bundle\CommentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\CommentBundle\Entity\Comment as BaseComment;

/**
 * Comment entity.
 *
 * @author Саша Стаменковић <umpirsky@gmail.com>
 */
class Comment extends BaseComment
{
    /**
     * Thread of this comment.
     *
     * @var Thread
     */
    protected $thread;
}
