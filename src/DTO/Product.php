<?php

namespace App\DTO;

class Product
{
		private $id;

		private $name;

		private $description;

		private $image;

		private $quantity;

		private $price;

		private $dimension;

		private $productDimension;

		public function getId()
		{
				return $this->id;
		}

		public function setId($id): void
		{
				$this->id = $id;
		}

		public function getName()
		{
				return $this->name;
		}

		public function setName($name): void
		{
				$this->name = $name;
		}

		public function getDescription()
		{
				return $this->description;
		}

		public function setDescription($description): void
		{
				$this->description = $description;
		}

		public function getImage()
		{
				return $this->image;
		}

		public function setImage($image): void
		{
				$this->image = $image;
		}

		public function getQuantity()
		{
				return $this->quantity;
		}

		public function setQuantity($quantity): void
		{
				$this->quantity = $quantity;
		}

		public function getPrice()
		{
				return $this->price;
		}

		public function setPrice($price): void
		{
				$this->price = $price;
		}

		public function getDimension()
		{
				return $this->dimension;
		}

		public function setDimension($dimension): void
		{
				$this->dimension = $dimension;
		}

		public function getProductDimension()
		{
				return $this->productDimension;
		}

		public function setProductDimension($productDimension): void
		{
				$this->productDimension = $productDimension;
		}
}