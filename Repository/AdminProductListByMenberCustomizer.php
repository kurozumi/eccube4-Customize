<?php

namespace Customize\Repository;

use Eccube\Doctrine\Query\WhereCustomizer;
use Eccube\Doctrine\Query\WhereClause;
use Eccube\Repository\QueryKey;
use Eccube\Entity\Member;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Description of AdminProductListByMenberCustomizer
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
            if($token->getUser() instanceof Member) {
                //return [WhereClause::eq('p.Creator', ':creator_id', ['creator_id' => $token->getUser()])];
            }
        }
        
        return [];
    }

    public function getQueryKey(): string
    {
        return QueryKey::PRODUCT_SEARCH_ADMIN;
    }

}
