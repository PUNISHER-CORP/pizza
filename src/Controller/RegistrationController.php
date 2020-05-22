<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Service\EmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @var EmailService
     */
    private $emailService;

	/**
	 * @var TranslatorInterface
	 */
    private $translator;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, EmailService $emailService, TranslatorInterface $translator)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->emailService = $emailService;
        $this->translator = $translator;
    }

	/**
	 * @Route("/register-ajax", name="app_register_ajax", options={"expose":"true"})
	 */
	public function registerAjax(Request $request): Response
	{
		$user = new User();
		$form = $this->createForm(RegistrationFormType::class, $user, [
			'action' => $this->generateUrl('app_register_ajax'),
			'method' => 'POST'
		]);

		$form->handleRequest($request);

		if ($request->isXmlHttpRequest()) {

			if (!$form->isValid()) {
				$errorCollection = [];
				foreach ($form->getErrors(true) as $error) {
					$errorCollection[] = $error->getMessage();
				}

				return new JsonResponse([
					'errors' => $errorCollection,
				]);
			}

			if ($form->isSubmitted() && $form->isValid()) {
				// encode the plain password
				$user->setPassword(
					$this->passwordEncoder->encodePassword(
						$user,
						$form->get('plainPassword')->getData()
					)
				);

				$entityManager = $this->getDoctrine()->getManager();
				$entityManager->persist($user);
				$entityManager->flush();

				$this->emailService->confirmRegistration($user);

				return new JsonResponse([
					'success' => $this->translator->trans('register.success')
				]);
			}
		}

		return $this->render('registration/register.html.twig', [
			'form' => $form->createView(),
		]);
    }
}
