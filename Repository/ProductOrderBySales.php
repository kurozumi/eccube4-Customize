<?php

namespace Customize\Repository;

use Eccube\Doctrine\Query\QueryCustomizer;
use Eccube\Repository\QueryKey;
use Doctrine\ORM\QueryBuilder;
use Eccube\Repository\OrderItemRepository;

/**
 * Description of ProductOrderBySalse
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
            $qb = $this->orderItemRepository->createQueryBuilder("oi")
                    ->select("COUNT(oi.Product)")
                    ->groupBy("oi.Product");
            
            $builder->addSelect(sprintf('(%s) AS HIDDEN total', $qb->getDql()))
                    ->orderBy("total", "DESC");
        }
    }

    public function getQueryKey(): string
    {
        return QueryKey::PRODUCT_SEARCH;
    }

}
