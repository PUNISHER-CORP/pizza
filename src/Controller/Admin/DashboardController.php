<?php

namespace App\Controller\Admin;

use App\Controller\AbstractCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/dashboard", name="admin_dashboard_")
 */
class DashboardController extends AbstractCrudController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('admin/dashboard/index.html.twig');
    }
}