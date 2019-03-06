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

namespace Customize\Repository;

use Eccube\Entity\Member;
use Eccube\Entity\Master\Authority;
use Eccube\Doctrine\Query\WhereCustomizer;
use Eccube\Doctrine\Query\WhereClause;
use Eccube\Repository\QueryKey;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Description of AdminOrderByMemberCustomizer
 *
 * @author Akira Kurozumi <info@a-zumi.net>
 */
class AdminOrderByMemberCustomizer extends WhereCustomizer {

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
                    //return [WhereClause::eq('p.Creator', ':creator_id', ['creator_id' => $token->getUser()])];                    
                }

            }
        }
        
        return [];
    }

    public function getQueryKey(): string
    {
        return QueryKey::ORDER_SEARCH_ADMIN;
    }

}
