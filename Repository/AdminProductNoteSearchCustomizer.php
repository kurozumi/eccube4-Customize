<?php

namespace Customize\Repository;

use Eccube\Doctrine\Query\QueryCustomizer;
use Eccube\Doctrine\Query\WhereClause;
use Eccube\Repository\QueryKey;
use Doctrine\ORM\QueryBuilder;

/**
 * 管理画面の商品一覧でショップ用メモを検索できるようにする
 *
 * @author Akira Kurozumi <info@a-zumi.net>
 */
class AdminProductNoteSearchCustomizer implements QueryCustomizer {

    protected $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function customize(QueryBuilder $builder, $params, $queryKey)
    {
        if ($params['id']) {
            // QueryBuilderに対してショップ用メモを検索対象するように設定
            $builder->orWhere("p.note LIKE :note");
            $builder->setParameter("note", '%'.$params['id'].'%');
        }
    }

    public function getQueryKey(): string
    {
        return QueryKey::PRODUCT_SEARCH_ADMIN;
    }

}
