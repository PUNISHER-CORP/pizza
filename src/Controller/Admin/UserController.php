<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Enum\OrderEnum;
use App\Form\UserType;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/admin/user")
 * @IsGranted("ROLE_ADMIN")
 */
class UserController extends AbstractController
{
	const LIMIT_PER_PAGE = 20;

	/**
	 * @Route("/", name="admin_user_index", methods={"GET"})
	 */
	public function index(Request $request, UserRepository $userRepository, PaginatorInterface $paginator): Response
	{
		$pagination = $paginator->paginate(
			$userRepository->findAll(),
			$request->query->getInt('page', 1),
			self::LIMIT_PER_PAGE
		);

		return $this->render('admin/user/index.html.twig', [
			'pagination' => $pagination,
		]);
	}

	/**
	 * @Route("/new", name="admin_user_new", methods={"GET","POST"})
	 */
	public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
	{
		$user = new User();
		$form = $this->createForm(UserType::class, $user);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$user->setPassword(
				$passwordEncoder->encodePassword(
					$user,
					$form->get('password')->getData()
				)
			);

			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($user);
			$entityManager->flush();

			return $this->redirectToRoute('admin_user_index');
		}

		return $this->render('admin/user/new.html.twig', [
			'user' => $user,
			'form' => $form->createView(),
		]);
	}

	/**
	 * @Route("/{id}", name="admin_user_show", methods={"GET"})
	 */
	public function show(User $user): Response
	{
		return $this->render('admin/user/show.html.twig', [
			'user' => $user,
			'deliveryMethod' => OrderEnum::getDeliveryMethods(),
			'paymentMethod' => OrderEnum::getPaymentMethods(),
		]);
	}

	/**
	 * @Route("/{id}/edit", name="admin_user_edit", methods={"GET","POST"})
	 */
	public function edit(Request $request, User $user): Response
	{
		$form = $this->createForm(UserType::class, $user);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$this->getDoctrine()->getManager()->flush();

			return $this->redirectToRoute('admin_user_index');
		}

		return $this->render('admin/user/edit.html.twig', [
			'user' => $user,
			'form' => $form->createView(),
		]);
	}

	/**
	 * @Route("/{id}", name="admin_user_delete", methods={"DELETE"})
	 */
	public function delete(Request $request, User $user): Response
	{
		if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->remove($user);
			$entityManager->flush();
		}

		return $this->redirectToRoute('admin_user_index');
	}
}
