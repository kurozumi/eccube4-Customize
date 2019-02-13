<?php

namespace Customize\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Eccube\Request\Context;

/**
 * フロントのタイトルタグの内容を書き換える
 *
 * @author Akira Kurozumi <info@a-zumi.net>
 */
class TitleSubscriber implements EventSubscriberInterface {
    
    public function __construct(
            Context $requestContext
    )
    {
        $this->requestContext = $requestContext;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            //KernelEvents::RESPONSE => [['onKernelResponse', 100000000]],
        ];
    }
    
    public function onKernelResponse(FilterResponseEvent $event)
    {
        // フロントページでない場合はスルー
        if (!$this->requestContext->isFront()) {
            return;
        }
        
        $response = $event->getResponse();
        $content = $response->getContent();
        
        $response->setContent(preg_replace("/<title>(.*)<\/title>/", "<title>タイトル変更</title>", $content));
        $event->setResponse($response);
    }

}
