<?php

namespace Customize\Repository;

use Eccube\Doctrine\Query\QueryCustomizer;
use Eccube\Doctrine\Query\WhereClause;
use Eccube\Repository\QueryKey;
use Doctrine\ORM\QueryBuilder;
use Eccube\Repository\TagRepository;

/**
 * 検索ボックスで商品タグ検索できるようにする
 *
 * @author Akira Kurozumi <info@a-zumi.net>
 */
class TagSearchCustomizer implements QueryCustomizer {

    protected $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function customize(QueryBuilder $builder, $params, $queryKey)
    {
        if ($params['name']) {
            // タグテーブルから検索キーワードに部分一致するタグを取得
            $result = $this->tagRepository->createQueryBuilder('t')
                    ->where("t.name LIKE :name")
                    ->setParameter("name", '%' . $params['name'] . '%')
                    ->getQuery()
                    ->getResult();

            // QueryBuilderに対してタグを検索対象するように設定
            if($result) {
                $builder->innerJoin("p.ProductTag", "pt");
                foreach ($result as $tag) {
                    $builder->orWhere("pt.Tag = :Tag");
                    $builder->setParameter("Tag", $tag->getId());
                }
            }
        }
    }

    public function getQueryKey(): string
    {
        return QueryKey::PRODUCT_SEARCH;
    }

}
