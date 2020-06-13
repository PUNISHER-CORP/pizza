<?php

namespace App\Controller;

use App\DTO\Cart;
use App\Entity\Admin\Order;
use App\Entity\Admin\OrderProduct;
use App\Entity\User;
use App\Enum\OrderEnum;
use App\Form\OrderType;
use App\Repository\Admin\DimensionRepository;
use App\Repository\Admin\DimensionsProductsRepository;
use App\Repository\Admin\ProductRepository;
use App\Service\CartService;
use App\Service\PayUConnectorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

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

	/**
	 * @var PayUConnectorService
	 */
	private $payUConnectorService;

	public function __construct(
		ProductRepository $productRepository,
		CartService $cartService,
		DimensionRepository $dimensionRepository,
		DimensionsProductsRepository $dimensionProductsRepository,
		SessionInterface $session,
		PayUConnectorService $payUConnectorService
	)
	{
		$this->productRepository = $productRepository;
		$this->cartService = $cartService;
		$this->dimensionRepository = $dimensionRepository;
		$this->dimensionProductsRepository = $dimensionProductsRepository;
		$this->session = $session;
		$this->payUConnectorService = $payUConnectorService;
	}

	/**
	 * @Route("/order/{type}", name="order__page", methods={"GET","POST"})
	 */
	public function orderPage(Request $request, string $type): Response
	{
		if($type == 'sushi') {
			$referer = $this->generateUrl('sushi_index');
			$refererPayU = 'sushi_index';
		}else {
			$referer = $this->generateUrl('pizza_index');
			$refererPayU = 'pizza_index';
		}

		$cartSession = $this->cartService->getProducts();

		if (!$cartSession) {
			return new RedirectResponse($referer);
		}

		$cartDto = new Cart($this->productRepository, $this->dimensionRepository);
		$cartDto->setProducts($cartSession['products']);

		$order = new Order();
		/** @var User $user */
		$user = $this->getUser();
		$form = $this->createForm(OrderType::class, $order, [
			'user' => $user
		]);
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

				$data = $form->getData();

				if ($form->has('saveData') && $form->get('saveData')->getData()) {
					$user->setName($data->getName());
					$user->setSurname($data->getSurname());
					$user->setStreet($data->getStreet());
					$user->setHouse($data->getHouse());
					$user->setFlat($data->getFlat());
					$user->setFlat($data->getFlat());
					$user->setPhone($data->getPhone());
					$user->setDeliveryMethod($data->getDelivery());
					$user->setPayMethod($data->getPayMethod());
					$entityManager->persist($user);
				}

				if ($data->getPayMethod() == OrderEnum::PAYU) {

					$orderPayU = $this->generateOrderForPayU($request, $refererPayU, $data);
					$result = \OpenPayU_Order::create($orderPayU);

					if ('SUCCESS' != $result->getStatus()) {
						throw new \Exception('Error during register payments.');
					}

					$orderId = $result->getResponse()->orderId;
					$redirectUri = $result->getResponse()->redirectUri;

					$order->setOrderPayuId($orderId);
					$order->setOrderPayuStatus(PayUConnectorService::ORDER_STATUS_PENDING);
					$entityManager->persist($order);
					$entityManager->flush();

					$this->session->clear();

					$this->addFlash('success', '');
					return new RedirectResponse($redirectUri);
				}

				$entityManager->persist($order);
				$entityManager->flush();

				$this->session->clear();

				$this->addFlash('success', '');
				return new RedirectResponse($referer);
			} catch (\Exception $e) {
				dd($e);
				$this->addFlash('danger', $e->getMessage());
				return new RedirectResponse($referer);
			}
		}

		return $this->render('order.html.twig', [
			'cart' => $cartDto,
			'referer' => $referer,
			'form' => $form->createView(),
			'type' => $type
		]);
	}

	public function generateOrderForPayU(Request $request, $referer,Order $data)
	{
		$order['notifyUrl'] = $this->generateUrl('app_payu_notify', [], UrlGeneratorInterface::ABSOLUTE_URL);
		$order['continueUrl'] = $this->generateUrl($referer, [], UrlGeneratorInterface::ABSOLUTE_URL);

		$order['customerIp'] = $request->getClientIp();
		$order['merchantPosId'] = \OpenPayU_Configuration::getOauthClientId() ? \OpenPayU_Configuration::getOauthClientId() : \OpenPayU_Configuration::getMerchantPosId();
		$order['description'] = 'New order';
		$order['currencyCode'] = 'PLN';
		$order['totalAmount'] = $data->getTotalPrice() * 100;
		$order['extOrderId'] = uniqid('', true);

		foreach ($data->getOrderProducts() as $key => $orderProduct) {
			$order['products'][$key]['name'] = $orderProduct->getProduct()->getName();
			$order['products'][$key]['unitPrice'] = $orderProduct->getQuantity();
			$order['products'][$key]['quantity'] = $orderProduct->getProductsDimensions()->getPrice() * 100;
		}

		$order['buyer']['email'] = $data->getEmail();
		$order['buyer']['phone'] = $data->getPhone();
		$order['buyer']['firstName'] = $data->getName();
		$order['buyer']['lastName'] = $data->getSurname();
		$order['buyer']['language'] = 'pl';

		return $order;
	}

	
}