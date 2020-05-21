<?php

namespace App\Form;

use App\Entity\Admin\Order;
use App\Enum\OrderEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\NotBlank;

class OrderType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('street', TextType::class, [
				'label' => 'order.street',
				'attr' => [
					'placeholder' => 'order.street',
					'class' => 'payment__input'
				],
				'constraints' => [
					new NotBlank()
				],
			])
			->add('house', TextType::class, [
				'label' => 'order.house',
				'attr' => [
					'placeholder' => 'order.house',
					'class' => 'payment__input'
				],
				'constraints' => [
					new NotBlank()
				],
			])
			->add('flat', TextType::class, [
				'label' => 'order.flat',
				'attr' => [
					'placeholder' => 'order.flat',
					'class' => 'payment__input'
				],
				'constraints' => [
					new NotBlank()
				],
			])
			->add('floor', TextType::class, [
				'label' => 'order.floor',
				'attr' => [
					'placeholder' => 'order.floor',
					'class' => 'payment__input'
				],
			])
			->add('name', TextType::class, [
				'label' => 'order.name',
				'attr' => [
					'placeholder' => 'order.name',
					'class' => 'payment__input'
				],
				'constraints' => [
					new NotBlank()
				],
			])
			->add('surname', TextType::class, [
				'label' => 'order.surname',
				'attr' => [
					'placeholder' => 'order.surname',
					'class' => 'payment__input'
				],
				'constraints' => [
					new NotBlank()
				],
			])
			->add('email', EmailType::class, [
				'label' => 'order.email',
				'attr' => [
					'placeholder' => 'order.email',
					'class' => 'payment__input'
				],
				'constraints' => [
					new NotBlank()
				],
			])
			->add('phone', TextType::class, [
				'label' => 'order.phone',
				'attr' => [
					'placeholder' => 'order.phone',
					'class' => 'payment__input'
				],
				'constraints' => [
					new NotBlank()
				],
			])
			->add('notes', TextareaType::class, [
				'label' => 'order.notes',
				'attr' => [
					'placeholder' => 'order.notes',
				],
			])
			->add('payMethod', ChoiceType::class, [
				'label' => 'order.payMethod',
				'choices' => array_flip(OrderEnum::getPaymentMethods()),
				'expanded' => true,
				'multiple' => false,
				'attr' => [
					'placeholder' => 'order.payMethod',
				],
				'constraints' => [
					new NotBlank()
				],
			])
			->add('delivery', ChoiceType::class, [
				'label' => 'order.deliveryMethod',
				'choices' => array_flip(OrderEnum::getDeliveryMethods()),
				'expanded' => true,
				'multiple' => false,
				'attr' => [
					'placeholder' => 'order.deliveryMethod',
				],
				'constraints' => [
					new NotBlank()
				],
			])
			->add('regulation', CheckboxType::class, [
				'mapped' => false,
				'label' => false,
				'constraints' => [
					new NotBlank()
				],
				'attr' => [
					'class' => 'checkbox'
				]
			])
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => Order::class,
			'attr' => [
				'novalidate' => 'novalidate'
			]
		]);
	}
}