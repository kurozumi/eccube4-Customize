<?php

namespace Customize\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Eccube\Event\EccubeEvents;
use Eccube\Event\EventArgs;

/**
 * Description of MailOrderListner
 *
 * @author Akira Kurozumi <info@a-zumi.net>
 */
class MailOrderSubscriber implements EventSubscriberInterface {

    public static function getSubscribedEvents(): array
    {
        return [
            //EccubeEvents::MAIL_ORDER => 'onMailOrder'
        ];
    }
    
    public function onMailOrder(EventArgs $event) {
        $message = $event->getArgument("message");
        $message->setBcc("test@a-zumi.net");
    }

}
