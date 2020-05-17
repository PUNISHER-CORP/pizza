<?php

namespace App\Enum;

class ProductType
{
		const PIZZA = 1;
		const SUSHI = 2;
		const DRINKS = 3;

		public static function getProductTypes()
		{
				return [
					self::PIZZA => 'product.pizza',
					self::SUSHI => 'product.sushi',
					self::DRINKS => 'product.drinks'
				];
		}
}