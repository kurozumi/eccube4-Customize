<?php

namespace Customize\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Eccube\Event\TemplateEvent;

/**
 * Description of ConversionTagSubscriber
 *
 * @author Akira Kurozumi <info@a-zumi.net>
 */
class ConversionTagSubscriber implements EventSubscriberInterface{

    public static function getSubscribedEvents(): array
    {
        return [
            'Shopping/complete.twig' => 'onTemplateShippingComplete',
        ];
    }
    
    public function onTemplateShippingComplete(TemplateEvent $event)
    {
        $event->addSnippet('conversiontag.twig');
    }

}
