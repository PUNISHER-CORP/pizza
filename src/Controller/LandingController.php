<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LandingController extends AbstractCrudController
{
    /**
     * @Route("/", name="landing_index")
     */
    public function index(Request $request): Response
    {
        return $this->render('landing.html.twig');
    }

    /**
     * @Route("/change-locale/{locale}", name="change_locale")
     */
    public function changeLocale(string $locale, Request $request): Response
    {
        $request->getSession()->set('_locale', $locale);

        return $this->redirectToRoute('landing_index');
    }
}