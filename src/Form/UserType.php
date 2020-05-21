<?php

namespace App\Form;

use App\Entity\User;
use App\Enum\OrderEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
			->add('email', EmailType::class, [
				'label' => 'user.email',
				'attr' => [
					'placeholder' => 'user.email',
				],
				'constraints' => [
					new NotBlank()
				],
			])
			->add('street', TextType::class, [
				'label' => 'user.street',
				'attr' => [
					'placeholder' => 'user.street',
				],
			])
			->add('house', TextType::class, [
				'label' => 'user.house',
				'attr' => [
					'placeholder' => 'user.house',
				],
			])
			->add('flat', TextType::class, [
				'label' => 'user.flat',
				'attr' => [
					'placeholder' => 'user.flat',
				],
			])
			->add('floor', TextType::class, [
				'label' => 'user.floor',
				'attr' => [
					'placeholder' => 'user.floor',
				],
			])
			->add('name', TextType::class, [
				'label' => 'user.name',
				'attr' => [
					'placeholder' => 'user.name',
				],
				'constraints' => [
					new NotBlank()
				],
			])
			->add('surname', TextType::class, [
				'label' => 'user.surname',
				'attr' => [
					'placeholder' => 'user.surname',
				],
				'constraints' => [
					new NotBlank()
				],
			])
			->add('phone', TextType::class, [
				'label' => 'user.phone',
				'attr' => [
					'placeholder' => 'user.phone',
				],
			])
			->add('payMethod', ChoiceType::class, [
				'label' => 'user.payMethod',
				'choices' => array_flip(OrderEnum::getPaymentMethods()),
				'expanded' => true,
				'multiple' => false,
				'attr' => [
					'placeholder' => 'user.payMethod',
				],
			])
			->add('deliveryMethod', ChoiceType::class, [
				'label' => 'user.deliveryMethod',
				'choices' => array_flip(OrderEnum::getDeliveryMethods()),
				'expanded' => true,
				'multiple' => false,
				'attr' => [
					'placeholder' => 'user.deliveryMethod',
				],
			])
			->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event): void {
				/** @var \App\Entity\User $user */
				$user = $event->getData();
				$form = $event->getForm();

				if (!$user || (null === $user->getId())) {
					$form
						->add('password', RepeatedType::class, [
							'type' => PasswordType::class,
							'first_options' => ['label' => 'user.password'],
							'second_options' => ['label' => 'user.repeatPassword'],
							'constraints' => [
								new NotBlank()
							],
						])
					;
				}
			})
		;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
			'attr' => [
				'novalidate' => 'novalidate'
			]
        ]);
    }
}
