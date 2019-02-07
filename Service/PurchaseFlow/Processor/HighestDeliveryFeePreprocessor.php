<?php

namespace Customize\Service\PurchaseFlow\Processor;

use Eccube\Service\PurchaseFlow\ItemHolderPreprocessor;
use Eccube\Entity\ItemHolderInterface;
use Eccube\Service\PurchaseFlow\PurchaseContext;
use Eccube\Repository\BaseInfoRepository;
use Eccube\Repository\DeliveryFeeRepository;
use Eccube\Annotation\ShoppingFlow;

/**
 * 商品送料が設定されている場合に一番高い送料を適用させる
 *
 * @author Akira Kurozumi <info@a-zumi.net>
 * 
 * @ShoppingFlow
 */
class HighestDeliveryFeePreprocessor implements ItemHolderPreprocessor {

    /** @var BaseInfo */
    protected $BaseInfo;

    /**
     * @var DeliveryFeeRepository
     */
    protected $deliveryFeeRepository;

    /**
     * DeliveryFeePreprocessor constructor.
     *
     * @param BaseInfoRepository $baseInfoRepository
     * @param DeliveryFeeRepository $deliveryFeeRepository
     */
    public function __construct(
            BaseInfoRepository $baseInfoRepository,
            DeliveryFeeRepository $deliveryFeeRepository
    )
    {
        $this->BaseInfo = $baseInfoRepository->get();
        $this->deliveryFeeRepository = $deliveryFeeRepository;
    }

    public function process(ItemHolderInterface $itemHolder, PurchaseContext $context)
    {
        $this->updateDeliveryFeeItem($itemHolder);
    }

    /**
     * @param ItemHolderInterface $itemHolder
     */
    private function updateDeliveryFeeItem(ItemHolderInterface $itemHolder)
    {
        $Order = $itemHolder;

        // 配送先毎に送料計算
        foreach ($Order->getShippings() as $Shipping) {

            // 商品ごとの送料設定が有効の場合
            if ($this->BaseInfo->isOptionProductDeliveryFee()) {

                // ここに商品毎に送料を格納する
                $deliveryFeeProducts = [];

                //明細の内容を確認
                foreach ($Shipping->getOrderItems() as $item) {
                    // 商品明細ではない場合スルー
                    if (!$item->isProduct()) {
                        continue;
                    }

                    // 商品送料に数量をかけて配列に格納
                    $deliveryFeeProducts[] = $item->getProductClass()->getDeliveryFee() * $item->getQuantity();
                }

                // 都道府県別送料を取得
                $DeliveryFee = $this->deliveryFeeRepository->findOneBy([
                    'Delivery' => $Shipping->getDelivery(),
                    'Pref' => $Shipping->getPref(),
                ]);

                // 商品送料が設定されていた場合
                if ($deliveryFeeProducts) {
                    // EC-CUBE本体で設定された送料を更新する
                    foreach ($Shipping->getOrderItems() as $item) {
                        // 送料明細の場合
                        if ($item->isDeliveryFee()) {
                            // 各商品の送料×数量で一番高い送料を取得
                            $deliveryFeeProduct = max($deliveryFeeProducts);

                            // 都道府県別送料と商品送料で高いほうの送料をセット
                            $item->setPrice(max([$DeliveryFee->getFee(), $deliveryFeeProduct]));
                        }
                    }
                }
            }
        }
    }

}
