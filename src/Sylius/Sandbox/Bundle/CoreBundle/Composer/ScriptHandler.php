<?php

namespace Sylius\Sandbox\Bundle\CoreBundle\Composer;

use Composer\Script\Event;

/**
 * Symlinks twitter bootstrap.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class ScriptHandler
{
    /**
     * Symlink twitter bootstrap.
     *
     * @param Event $event
     */
    static public function symlinkTwitterBootstrap(Event $event)
    {
        $IO = $event->getIO();
        $composer = $event->getComposer();

        $dir = __DIR__;
        while (!is_dir($dir.'/vendor/twitter/bootstrap'))
            $dir = dirname($dir);

        $symlinkTarget = $dir.'/vendor/twitter/bootstrap';
        $symlinkName = __DIR__.'/../Resources/public/bootstrap';

        if (!@readlink($symlinkName)) {
            $IO->write("<info>[Sylius]</info> Creating symlink for Twitter Bootstrap files.");
            if(false === symlink($symlinkTarget, $symlinkName)){
                throw new \Exception('Error occured when trying to create a symlink.');
            }
        }
    }
}
