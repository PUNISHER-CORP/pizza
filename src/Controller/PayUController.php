<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PayUController
{
	/**
	 * @Route("notify", name="app_payu_notify")
	 */
	public function notify(Request $request): Response
	{
		if ($request->getMethod() == 'POST') {
			$body = file_get_contents('php://input');
			$data = trim($body);

			try {
				if (!empty($data)) {
					$result = \OpenPayU_Order::consumeNotification($data);
				}

				if ($result->getResponse()->order->orderId) {

					/* Check if OrderId exists in Merchant Service, update Order data by OrderRetrieveRequest */
					$order = \OpenPayU_Order::retrieve($result->getResponse()->order->orderId);
					if($order->getStatus() == 'SUCCESS'){
						return new Response(Response::HTTP_OK);
					}
				}
			} catch (\OpenPayU_Exception $e) {
				echo $e->getMessage();
			}
		}

		return new Response();
	}
}