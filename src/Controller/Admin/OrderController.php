<?php

namespace App\Controller\Admin;

use App\Entity\Admin\Order;
use App\Enum\OrderEnum;
use App\Enum\ProductType;
use App\Repository\Admin\OrderRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/order")
 */
class OrderController extends AbstractController
{
	const LIMIT_PER_PAGE = 20;

	/**
	 * @Route("/", name="admin_order_index", methods={"GET"})
	 */
	public function index(Request $request, OrderRepository $categoryRepository, PaginatorInterface $paginator): Response
	{
		$pagination = $paginator->paginate(
			$categoryRepository->findAll(),
			$request->query->getInt('page', 1),
			self::LIMIT_PER_PAGE
		);

		return $this->render('admin/order/index.html.twig', [
			'pagination' => $pagination,
			'deliveryMethod' => OrderEnum::getDeliveryMethods(),
			'paymentMethod' => OrderEnum::getPaymentMethods(),
		]);
	}

	/**
	 * @Route("/{id}", name="admin_order_show", methods={"GET"})
	 */
	public function show(Order $order): Response
	{
		return $this->render('admin/order/show.html.twig', [
			'order' => $order,
			'type' => ProductType::getProductTypes(),
			'deliveryMethod' => OrderEnum::getDeliveryMethods(),
			'paymentMethod' => OrderEnum::getPaymentMethods(),
		]);
	}
}