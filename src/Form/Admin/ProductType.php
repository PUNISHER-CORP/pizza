<?php

namespace App\Form\Admin;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use App\Entity\Admin\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('translations', TranslationsType::class, [
                'fields' => [
                    'name' => [
                        'field_type' => TextType::class,
                        'label' => 'product.name',
                        'constraints' => [
                            new NotBlank()
                        ]
                    ],
                    'description' => [
                        'field_type' => TextType::class,
                        'label' => 'product.description',
                    ],
                ],
                'label' => false
            ])
						->add('type', ChoiceType::class, [
								'label' => 'product.type',
								'choices' => array_flip(\App\Enum\ProductType::getProductTypes()),
								'placeholder' => 'form.choose',
								'constraints' => [
										new NotBlank()
								]
						])
            ->add('imageFile', VichImageType::class, [
                'label' => 'product.mainImage',
                'allow_delete' => true,
                'translation_domain' => 'messages',
            ])
            ->add('productsCategories', CollectionType::class , [
                'entry_type'   => ProductsCategoriesType::class,
                'label' => 'product.categories',
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'error_bubbling' => false,
            ])
            ->add('productsDimensions', CollectionType::class , [
                'entry_type'   => DimensionsProductsType::class,
                'label' => 'dimension.dimensions',
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'error_bubbling' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
            'attr' => [
                'novalidate' => 'novalidate'
            ]
        ]);
    }
}
