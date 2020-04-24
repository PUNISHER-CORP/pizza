<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LandingController extends AbstractCrudController
{
    /**
     * @Route("/", name="landing_index")
     */
    public function index(): Response
    {
        return $this->render('base.html.twig');
    }
}