<?php

namespace Customize\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\AuthenticationEvents;
use Symfony\Component\Security\Core\Event\AuthenticationFailureEvent;

/**
 * ログインに失敗したときに何かする
 *
 * @author Akira Kurozumi <info@a-zumi.net>
 */
class AuthenticationFailureSubscriber implements EventSubscriberInterface {

    public static function getSubscribedEvents(): array
    {
        return [
            AuthenticationEvents::AUTHENTICATION_FAILURE => "onAuthenticationFailure"
        ];
    }
    
    public function onAuthenticationFailure(AuthenticationFailureEvent $event)
    {
        $token = $event->getAuthenticationToken();
        
        switch($token->getProviderKey()) {
            case "customer":
                // 会員がログイン失敗したときに何かする
                var_dump("customer");
                $User = $token->getUser();
                break;
            case "admin":
                // メンバーがログイン失敗したときに何かする
                var_dump("admin");
                $User = $token->getUser();
                break;
        }
    }

}
