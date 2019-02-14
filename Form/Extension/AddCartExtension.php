<?php

namespace Customize\Form\Extension;

use Eccube\Form\Type\AddCartType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * Description of AddCartExtension
 *
 * @author Akira Kurozumi <info@a-zumi.net>
 */
class AddCartExtension extends AbstractTypeExtension {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $Product = $options['product'];

        if ($Product->getStockFind()) {
            $builder->add("datetime", DateTimeType::class, [
                "label" => "日時",
                'attr' => [
                    'data-target' => 'datetime',
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                ],
                "mapped" => false,
            ]);
            
            $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
                /** @var CartItem $CartItem */
                $CartItem = $event->getData();
                $form = $event->getForm();
                $ProductClass = $CartItem->getProductClass();
                var_dump($form->get("datetime")->getData());
                // FIXME 価格の設定箇所、ここでいいのか
                if ($ProductClass) {
                    $CartItem
                        ->setProductClass($ProductClass)
                        ->setPrice($ProductClass->getPrice02IncTax());
                }
            });
        }
    }

    public function getExtendedType()
    {
        return AddCartType::class;
    }

}
