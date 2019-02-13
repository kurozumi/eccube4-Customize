<?php

namespace Customize\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Eccube\Request\Context;

/**
 * Description of ModalSubscriber
 *
 * @author Akira Kurozumi <info@a-zumi.net>
 */
class ModalSubscriber implements EventSubscriberInterface {

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER_ARGUMENTS => [['onKernelController', 100000000]]
        ];
    }

    protected $requestContext;

    public function __construct(Context $requestContext)
    {
        $this->requestContext = $requestContext;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        // フロントページではない場合スルー
        if(!$this->requestContext->isFront()) {
            return;
        }
        
        
    }

}
