<?php

namespace App\Controller;

use App\DTO\Cart;
use App\Repository\Admin\DimensionRepository;
use App\Repository\Admin\ProductRepository;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class CartController extends AbstractController
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var DimensionRepository
     */
    private $dimensionRepository;

    /**
     * @var CartService
     */
    private $cartService;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    public function __construct(ProductRepository $productRepository, CartService $cartService, TranslatorInterface $translator, DimensionRepository $dimensionRepository)
    {
        $this->productRepository = $productRepository;
        $this->cartService = $cartService;
        $this->translator = $translator;
        $this->dimensionRepository = $dimensionRepository;
    }

	/**
	 * @Route("/cart-quantity", name="cart-quantity")
	 */
	public function getQuantityInCart(): Response
	{
		$cartSession = $this->cartService->getProducts();

		if (!$cartSession) {
			return new Response(null);
		}

		$cartDto = new Cart($this->productRepository, $this->dimensionRepository);
		$cartDto->setProducts($cartSession['products']);
		$quantity = $cartDto->getQuantity();

		return new Response(isset($quantity) ? $quantity : null);
	}

	/**
	 * @Route("/show", name="show_cart", options={"expose": true})
	 */
	public function show(Request $request): Response
	{
		$cartSession = $this->cartService->getProducts();

		if (!$cartSession) {
			return $this->render('cart/popup.html.twig', [
				'cart' => [],
			]);
		}
		$cartDto = new Cart($this->productRepository, $this->dimensionRepository);
		$cartDto->setProducts($cartSession['products']);

		return $this->render('cart/popup.html.twig', [
			'cart' => $cartDto,
		]);
	}

    /**
     * @Route("/add-product/{productId}/{quantity}/{dimensionId}", name="cart_add_product", methods={"GET"}, requirements={"productId": "\d+"}, options={"expose": true})
     */
    public function addProductToCart(int $productId, int $quantity, int $dimensionId): JsonResponse
    {
        $product = $this->productRepository->find($productId);

        try {
            $products = $this->cartService->addProduct($product, $quantity, $dimensionId);
        } catch (\Exception $e) {
            return new JsonResponse(['status' => Response::HTTP_FORBIDDEN, 'message' => $this->translator->trans('cart.errorOnProductAdd')]);
        }

        return new JsonResponse(['status' => Response::HTTP_OK, 'quantity' => $products['quantity']]);
    }

	/**
	 * @Route("/delete-product/{productId}/{dimensionId}", name="cart_delete_product")
	 */
	public function deleteProduct(Request $request, $productId, $dimensionId)
	{
		$products = $this->cartService->getProducts();

		unset($products['products'][$productId][$dimensionId]);
		$this->cartService->save($products);

		$referer = $request->headers->get('referer');
		return new RedirectResponse($referer);
    }
}