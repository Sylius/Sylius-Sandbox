<?php

/*
* This file is part of the Sylius sandbox application.
*
* (c) Paweł Jędrzejewski
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Sylius\Sandbox\Bundle\CommentBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Comment sandbox bundle.
 *
 * @author Саша Стаменковић <umpirsky@gmail.com>
 */
class SandboxCommentBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'FOSCommentBundle';
    }
}
