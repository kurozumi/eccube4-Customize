<?php

namespace Customize\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ImageSelectSubscriber implements EventSubscriberInterface
{
    public function addAsset($event)
    {
        // ...
    }

    public static function getSubscribedEvents()
    {
        return [
           'Product/list.twig' => 'addAsset',
            'Product/detail.twig' => 'addAsset',
        ];
    }
}
