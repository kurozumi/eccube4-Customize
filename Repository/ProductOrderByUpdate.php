<?php

namespace Customize\Repository;

use Eccube\Doctrine\Query\QueryCustomizer;
use Eccube\Repository\QueryKey;
use Doctrine\ORM\QueryBuilder;

/**
 * 更新日時順で並べ替えできるようにする
 *
 * 管理画面＞設定＞システム設定＞マスターデータ管理の「mtb_product_list_order_by」で更新日時順を追加する。
 * IDは4を設定
 * 
 * @author Akira Kurozumi <info@a-zumi.net>
 */
class ProductOrderByUpdate implements QueryCustomizer {

    public function customize(QueryBuilder $builder, $params, $queryKey)
    {
        if(!empty($params["orderby"]) && $params["orderby"]->getId() == 4) {
            //$builder->orderBy('p.update_date', 'DESC');
        }
        
    }

    public function getQueryKey(): string
    {
        return QueryKey::PRODUCT_SEARCH;
    }

}
