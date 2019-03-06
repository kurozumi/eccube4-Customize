<?php

namespace Customize\Repository;

use Eccube\Doctrine\Query\WhereCustomizer;
use Eccube\Doctrine\Query\WhereClause;
use Eccube\Repository\QueryKey;
use Eccube\Entity\Member;
use Eccube\Entity\Master\Authority;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * 管理画面にログインしたら自分が登録した商品しから商品一覧に表示させないようにする
 *
 * @author Akira Kurozumi <info@a-zumi.net>
 */
class AdminProductListByMenberCustomizer extends WhereCustomizer {

    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }
    
    protected function createStatements($params, $queryKey)
    {
        if (null !== $token = $this->tokenStorage->getToken()) {
            // ユーザーがメンバーの場合
            if($token->getUser() instanceof Member) {
                // メンバーが管理者ではない場合
                if($token->getUser()->getAuthority()->getId() != Authority::ADMIN) {
                    return [WhereClause::eq('p.Creator', ':creator_id', ['creator_id' => $token->getUser()])];                    
                }

            }
        }
        
        return [];
    }

    public function getQueryKey(): string
    {
        return QueryKey::PRODUCT_SEARCH_ADMIN;
    }

}
