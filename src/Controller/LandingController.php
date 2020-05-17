<?php

namespace App\Controller;

use App\Enum\ProductType;
use App\Repository\Admin\ProductRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LandingController extends AbstractCrudController
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
		 * Pizza landing
     * @Route("/", name="pizza_index")
     */
    public function index(Request $request): Response
    {
        $products = $this->productRepository->findBy(['type' => ProductType::PIZZA]);
        $drinks = $this->productRepository->findBy(['type' => ProductType::DRINKS]);

        return $this->render('pizza.html.twig', [
            'products' => $products,
						'drinks' => $drinks,
     				'currentLanguage' => $request->getSession()->get('_locale', 'pl')
        ]);
    }

    /**
		 *
     * @Route("/landing", name="landing_index")
     */
    public function landing(Request $request): Response
    {
        $products = $this->productRepository->findBy(['type' => ProductType::PIZZA]);

        return $this->render('landing.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/change-locale/{locale}", name="change_locale")
     */
    public function changeLocale(string $locale, Request $request): RedirectResponse
    {
        $request->getSession()->set('_locale', $locale);
				$referer = $request->headers->get('referer');

        return new RedirectResponse($referer);
    }
}