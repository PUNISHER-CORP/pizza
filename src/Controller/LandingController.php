<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LandingController extends AbstractCrudController
{
    /**
     * @Route("/{_locale}/", name="landing_index")
     */
    public function index(): Response
    {
        return $this->render('landing.html.twig');
    }
}