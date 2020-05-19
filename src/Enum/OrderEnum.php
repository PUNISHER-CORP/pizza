<?php

namespace App\Enum;

class OrderEnum
{
		const PAYU = 1;
		const CASH = 2;

		const IN_PLACE = 1;
		const DELIVERY= 2;

		public static function getPaymentMethods(): array
		{
				return [
						self::PAYU => 'order.payu',
						self::CASH => 'order.cash'
				];
		}

		public static function getDeliveryMethods(): array
		{
				return [
						self::IN_PLACE => 'order.inPlace',
						self::DELIVERY => 'order.delivery'
				];
		}
}