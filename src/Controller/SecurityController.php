<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login", options={"expose":"true"})
     */
    public function login(AuthenticationUtils $authenticationUtils, UrlGeneratorInterface $urlGenerator): Response
    {
         if ($this->getUser()) {
             return $this->redirectToRoute('admin_order_index');
         }

        return new RedirectResponse($urlGenerator->generate('preview'));
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}