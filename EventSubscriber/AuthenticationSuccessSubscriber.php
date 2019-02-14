<?php

namespace Customize\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\AuthenticationEvents;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;

/**
 * ログインしたときに何かする
 *
 * @author Akira Kurozumi <info@a-zumi.net>
 */
class AuthenticationSuccessSubscriber implements EventSubscriberInterface {

    public static function getSubscribedEvents(): array
    {
        return [
            AuthenticationEvents::AUTHENTICATION_SUCCESS => "onAuthenticationSuccess"
        ];
    }
    
    public function onAuthenticationSuccess(AuthenticationEvent $event)
    {
        $token = $event->getAuthenticationToken();
        
        if(!$token->getRoles()) {
            return;
        }
        
        switch($token->getRoles()) {
            case "ROLE_USER":
                // 会員がログインしたときに何かする
                var_dump("customer");
                $User = $token->getUser();
                break;
            case "ROLE_ADMIN":
                // メンバーがログインしたときに何かする
                var_dump("admin");
                $User = $token->getUser();
                break;
        }
    }

}
