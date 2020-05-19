<?php

namespace App\Controller;

use App\DTO\Cart;
use App\Entity\Admin\Order;
use App\Entity\Admin\OrderProduct;
use App\Form\OrderType;
use App\Repository\Admin\DimensionRepository;
use App\Repository\Admin\DimensionsProductsRepository;
use App\Repository\Admin\ProductRepository;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
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
	 * @var DimensionsProductsRepository
	 */
	private $dimensionProductsRepository;

	/**
	 * @var CartService
	 */
	private $cartService;

	/**
	 * @var SessionInterface
	 */
	private $session;

	public function __construct(
		ProductRepository $productRepository,
		CartService $cartService,
		DimensionRepository $dimensionRepository,
		DimensionsProductsRepository $dimensionProductsRepository,
		SessionInterface $session
	)
	{
		$this->productRepository = $productRepository;
		$this->cartService = $cartService;
		$this->dimensionRepository = $dimensionRepository;
		$this->dimensionProductsRepository = $dimensionProductsRepository;
		$this->session = $session;
	}

	/**
	 * @Route("/order", name="order__page", methods={"GET","POST"})
	 */
	public function orderPage(Request $request): Response
	{
		$referer = $request->headers->get('referer');
		$previewRoute = $this->generateUrl('preview');
		$cartSession = $this->cartService->getProducts();

		if (!$cartSession) {
			return new RedirectResponse($previewRoute);
		}

		$cartDto = new Cart($this->productRepository, $this->dimensionRepository);
		$cartDto->setProducts($cartSession['products']);

		$order = new Order();
		$form = $this->createForm(OrderType::class, $order);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			try {
				foreach ($cartDto->getProducts() as $product) {
					$orderProduct = new OrderProduct();
					$productEntity = $this->productRepository->find($product->getId());
					$orderProduct->setProduct($productEntity);
					$dimensionEntity = $this->dimensionProductsRepository->find($product->getProductDimension());
					$orderProduct->setProductsDimensions($dimensionEntity);
					$orderProduct->setQuantity($product->getQuantity());
					$order->addOrderProduct($orderProduct);
				}
				$order->setTotalPrice($cartDto->getTotalPrice());
				$entityManager = $this->getDoctrine()->getManager();
				$entityManager->persist($order);
				$entityManager->flush();

				$this->session->clear();

				$this->addFlash('success', '');
				return new RedirectResponse($previewRoute);
			} catch (\Exception $e) {
				$this->addFlash('danger', '');
				return new RedirectResponse($previewRoute);
			}
		}

		return $this->render('order.html.twig', [
			'cart' => $cartDto,
			'referer' => $referer,
			'form' => $form->createView(),
		]);
	}
}