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

namespace Customize\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Eccube\Form\Type\RepeatedPasswordType;
use Eccube\Entity\Order;

/**
 * Description of NonMemberRegister
 *
 * @author Akira Kurozumi <info@a-zumi.net>
 */
class NonMemberRegisterType extends AbstractType{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $Order = $options["Order"];
        
        $builder
                ->add('password', RepeatedPasswordType::class)
                ->add('order_id', HiddenType::class, [
                   "data" => $Order->getId() 
                ])
                ->add('button', SubmitType::class, [
                    "label" => "会員登録する"
                ])
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        // Orderエンティティをオプションに追加するのを必須にする
        $resolver
                ->setRequired("Order")
                ->setAllowedTypes("Order", Order::class);
    }
}
