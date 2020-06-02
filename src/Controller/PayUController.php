<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
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
		return new RedirectResponse('/');
	}
}