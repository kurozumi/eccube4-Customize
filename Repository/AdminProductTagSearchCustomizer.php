<?php

namespace Customize\Repository;

use Eccube\Doctrine\Query\QueryCustomizer;
use Eccube\Doctrine\Query\WhereClause;
use Eccube\Repository\QueryKey;
use Doctrine\ORM\QueryBuilder;
use Eccube\Repository\TagRepository;

/**
 * Description of AdminProductTagSearchCustomizer
 *
 * @author Akira Kurozumi <info@a-zumi.net>
 */
class AdminProductTagSearchCustomizer implements QueryCustomizer {

    protected $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function customize(QueryBuilder $builder, $params, $queryKey)
    {
        if ($params['id']) {
            // タグテーブルから検索キーワードに部分一致するタグを取得
            $result = $this->tagRepository->createQueryBuilder('t')
                    ->where("t.name LIKE :name")
                    ->setParameter("name", '%' . $params['id'] . '%')
                    ->getQuery()
                    ->getResult();

            // QueryBuilderに対してタグを検索対象するように設定
            $builder->innerJoin("p.ProductTag", "pt");
            foreach ($result as $tag) {
                $builder->orWhere("pt.Tag = :Tag");
                $builder->setParameter("Tag", $tag->getId());
            }
        }
    }

    public function getQueryKey(): string
    {
        return QueryKey::PRODUCT_SEARCH_ADMIN;
    }

}
