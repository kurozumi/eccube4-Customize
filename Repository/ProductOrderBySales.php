<?php

namespace Customize\Repository;

use Eccube\Doctrine\Query\QueryCustomizer;
use Eccube\Repository\QueryKey;
use Doctrine\ORM\QueryBuilder;
use Eccube\Repository\OrderItemRepository;

/**
 * 販売個数順で並べ替えできるようにする
 * 
 * 管理画面＞設定＞システム設定＞マスターデータ管理の「mtb_product_list_order_by」で販売個数順を追加する。
 * IDは4を設定
 *
 * @author Akira Kurozumi <info@a-zumi.net>
 */
class ProductOrderBySales implements QueryCustomizer {

    protected $orderItemRepository;


    public function __construct(OrderItemRepository $orderItemRepository)
    {
        $this->orderItemRepository = $orderItemRepository;
    }
    
    public function customize(QueryBuilder $builder, $params, $queryKey)
    {
        if(!empty($params["orderby"]) && $params["orderby"]->getId() == 4) {
            //dtb_order_itemテーブルで商品個数を集計するサブクエリ
            $qb = $this->orderItemRepository->createQueryBuilder("oi")
                    ->select("COUNT(oi.Product)")
                    ->where("oi.Product = p.id")
                    ->groupBy("oi.Product");
            
            // 上記のサブクエリをselectに追加
            $builder->addSelect(sprintf('(%s) AS HIDDEN total', $qb->getDql()))
                    ->orderBy("total", "DESC");
        }
    }

    public function getQueryKey(): string
    {
        return QueryKey::PRODUCT_SEARCH;
    }

}
