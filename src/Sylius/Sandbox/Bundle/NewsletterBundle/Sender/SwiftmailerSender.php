<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Sandbox\Bundle\NewsletterBundle\Sender;

use Sylius\Bundle\NewsletterBundle\Model\NewsletterInterface;
use Sylius\Bundle\NewsletterBundle\Sender\SenderInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class SwiftmailerSender extends ContainerAware implements SenderInterface
{
    public function send(NewsletterInterface $newsletter)
    {
        $mailer = $this->container->get('mailer');
        $subscribers = $this->container->get('sylius_newsletter.manager.subscriber')->findSubscribersBy(array('enabled' => true));

        foreach ($subscribers as $subscriber) {
            $message = \Swift_Message::newInstance()
            ->setSubject($newsletter->getTitle())
            ->setFrom("no-reply@example.com")
            ->setBody($newsletter->getContent())
            ->setTo($subscriber->getEmail());

            $mailer->send($message);
        }

        $newsletter->setSent(true);
    }

    public function supports(NewsletterInterface $newsletter)
    {
        return true;
    }
}
