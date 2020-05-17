<?php

namespace App\Form\Admin;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use App\Entity\Admin\Dimension;
use App\Entity\Admin\DimensionsProducts;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class DimensionsProductsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dimension', EntityType::class, [
                'class' => Dimension::class,
                'choice_label' => 'name',
                'label' => false
            ])
            ->add('price', NumberType::class, [
								'label' => 'product.price',
								'scale' => 2,
								'constraints' => [
										new NotBlank()
								],
            ])
        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DimensionsProducts::class,
            'attr' => [
                'novalidate' => 'novalidate'
            ]
        ]);
    }
}