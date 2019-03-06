<?php

/*
 * Copyright (C) 2019 Akira Kurozumi <info@a-zumi.net>.
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301  USA
 */

namespace Customize\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Eccube\Event\TemplateEvent;

/**
 * Description of ImagePickerSubscriber
 *
 * @author Akira Kurozumi <info@a-zumi.net>
 */
class ImagePickerSubscriber implements EventSubscriberInterface {

    public static function getSubscribedEvents(): array
    {
        return [
            'Product/detail.twig' => 'addSnippet'
        ];
    }

    public function addSnippet(TemplateEvent $event)
    {
        //$event->addSnippet('@Customize/default/js/script.twig');
    }
}
