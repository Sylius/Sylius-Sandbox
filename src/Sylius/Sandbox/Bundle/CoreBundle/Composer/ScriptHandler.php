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

        $IO->write("<info>[Sylius]</info> Creating symlink for Twitter Bootstrap files.");

        $symlinkTarget = __DIR__.'/../../../../../../vendor/twitter/bootstrap';
        $symlinkName = __DIR__.'/../Resources/public/bootstrap';

        if (!file_exists($symlinkTarget)) {
            if(false === symlink($symlinkTarget, $symlinkName)){
                throw new \Exception('Error occured when trying to create a symlink.');
            }
        }
    }
}
