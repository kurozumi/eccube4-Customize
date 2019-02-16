<?php

namespace Customize\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Eccube\Event\EccubeEvents;
use Eccube\Event\EventArgs;
use Abraham\TwitterOAuth\TwitterOAuth;

/**
 * ライブラリのインストールが必要
 * bin/console eccube:composer:require abraham/twitteroauth
 * 
 * 新着情報を投稿・更新したときにツイートするイベント
 *
 * @author Akira Kurozumi <info@a-zumi.net>
 */
class TweetSubscriber implements EventSubscriberInterface {
    
    private const CONSUMER_KEY = "CONSUMER_KEY";
    private const CONSUMER_SECRET = "CONSUMER_SECRET";
    private const ACCESS_TOKEN = "ACCESS_TOKEN";
    private const ACCESS_TOKEN_SECRET = "ACCESS_TOKEN_SECRET";

    public static function getSubscribedEvents(): array
    {
        return [
            EccubeEvents::ADMIN_CONTENT_NEWS_EDIT_COMPLETE => 'onAdminContentNewsEditComplete',
        ];
    }
    
    public function onAdminContentNewsEditComplete(EventArgs $event)
    {
        $News = $event->getArgument("News");
        
        if($News->getVisible()) {
            $connection = new TwitterOAuth(self::CONSUMER_KEY, self::CONSUMER_SECRET, self::ACCESS_TOKEN, self::ACCESS_TOKEN_SECRET);
            $connection->post("statuses/update", ["status" => $News->getTitle()." ".$News->getUrl()]);
        }

    }

}
