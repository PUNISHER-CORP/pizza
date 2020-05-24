<?php

namespace App\Controller;

use App\Enum\ProductType;
use App\Repository\Admin\CategoryRepository;
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

	/**
	 * @var CategoryRepository
	 */
    private $categoryRepository;

	public function __construct(ProductRepository $productRepository, CategoryRepository $categoryRepository)
	{
		$this->productRepository = $productRepository;
		$this->categoryRepository = $categoryRepository;
	}

	/**
	 * @Route("/", name="preview", host="home.slupsk.pl")
	 */
	public function preview(): Response
	{
		return $this->render('preview.html.twig');
	}

	/**
	 * Pizza landing
     * @Route("/pizza", name="pizza_index", host="pizza.home.slupsk.pl")
     */
    public function index(Request $request): Response
    {
        $products = $this->productRepository->findBy(['type' => ProductType::PIZZA]);
        $drinks = $this->productRepository->findBy(['type' => ProductType::DRINKS]);

        return $this->render('pizza.html.twig', [
            'products' => $products,
			'drinks' => $drinks,
			'currentLanguage' => $request->getSession()->get('_locale', 'pl'),
			'cart' => null
        ]);
    }

    /**
	 * Sushi landing
     * @Route("/sushi", name="sushi_index", host="sushi.home.slupsk.pl")
     */
    public function landing(Request $request): Response
    {
		$products = $this->productRepository->findBy(['type' => ProductType::SUSHI]);

		$productsByCategories = [];

		foreach ($products as $product) {
			foreach ($product->getProductsCategories() as $productsCategory) {
				$productsByCategories[$productsCategory->getCategory()->getId()][] = $product;
			}
		}

		$drinks = $this->productRepository->findBy(['type' => ProductType::DRINKS]);
		$categories = $this->categoryRepository->findAll();

		return $this->render('sushi.html.twig', [
			'products' => $productsByCategories,
			'drinks' => $drinks,
			'categories' => $categories,
			'currentLanguage' => $request->getSession()->get('_locale', 'pl'),
			'cart' => null
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