<?php

namespace App\Controller\Admin;

use App\Entity\Admin\Order;
use App\Enum\OrderEnum;
use App\Enum\ProductType;
use App\Repository\Admin\OrderRepository;
use App\Service\PayUConnectorService;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/order")
 * @IsGranted("ROLE_ADMIN")
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
			$categoryRepository->findBy([], ['orderDate' => 'DESC']),
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
	public function show(Order $order, PayUConnectorService $payUConnectorService): Response
	{
		$em = $this->getDoctrine()->getManager();

		if($order->getPayMethod() == OrderEnum::PAYU && $order->getOrderPayuId() && $order->getOrderPayuStatus() != PayUConnectorService::ORDER_STATUS_COMPLETED ) {
			$result = \OpenPayU_Order::retrieve($order->getOrderPayuId());
			$orderStatus = $result->getResponse()->orders[0]->status;
			$order->setOrderPayuStatus($orderStatus);
			$em->persist($order);
			$em->flush();
		}

		if ($order->getShowed() == Order::NO) {
			$order->setShowed(Order::YES);
			$em->persist($order);
			$em->flush();
		}

		return $this->render('admin/order/show.html.twig', [
			'order' => $order,
			'type' => ProductType::getProductTypes(),
			'deliveryMethod' => OrderEnum::getDeliveryMethods(),
			'paymentMethod' => OrderEnum::getPaymentMethods(),
			'orderStatuses' => PayUConnectorService::getStatuses()
		]);
	}

	/**
     * @Route("/{id}", name="admin_order_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Order $order): Response
    {
        if ($this->isCsrfTokenValid('delete'.$order->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($order);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_order_index');
    }
}