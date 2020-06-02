<?php

namespace App\DTO;

use App\Entity\Admin\DimensionsProducts;
use App\Repository\Admin\DimensionRepository;
use App\Repository\Admin\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;

class Cart
{
	/**
	 * @var string
	 */
	private $totalPrice;

	/**
	 * @var int
	 */
	private $quantity;

	/**
	 * @var ArrayCollection
	 */
	private $products;

	/**
	 * @var ProductRepository
	 */
	private $productRepository;

	/**
	 * @var DimensionRepository
	 */
	private $dimensionRepository;

	public function __construct(ProductRepository $productRepository, DimensionRepository $dimensionRepository)
	{
		$this->products = new ArrayCollection();
		$this->productRepository = $productRepository;
		$this->dimensionRepository = $dimensionRepository;
	}

	public function getTotalPrice(): ?float
	{
		return $this->totalPrice;
	}

	public function setTotalPrice(?float $totalPrice): void
	{
		$this->totalPrice = $totalPrice;
	}

	public function getQuantity(): ?int
	{
		return $this->quantity;
	}

	public function setQuantity(?int $quantity): void
	{
		$this->quantity = $quantity;
	}

	public function getProducts()
	{
		return $this->products;
	}

	public function setProducts(array $products): void
	{
		foreach ($products as $key => $dimensions) {
			foreach ($dimensions as $dimensionId => $productArray){
				$product = $this->productRepository->find($productArray['id']);
				$dimension = $this->dimensionRepository->find($dimensionId);
				$productDto = new Product();
				$productDto->setId($product->getId());
				$productDto->setName($product->getName());
				$productDto->setDescription($product->getDescription());
				$productDto->setImage($product->getImage());
				$productDto->setQuantity($productArray['quantity']);
				$productDto->setDimension($dimension);

				$productDimensions = $product->getProductsDimensions();
				/** @var DimensionsProducts $productDimension */
				foreach ($productDimensions as $productDimension) {
					if($productDimension->getDimension()->getId() == $dimension->getId() && $productDimension->getProduct()->getId() == $product->getId()) {
						$productDto->setPrice($productDimension->getPrice());
						$productDto->setProductDimension($productDimension->getId());
					}
				}

				$total = $productDto->getQuantity() * $productDto->getPrice();
				$this->setTotalPrice($this->getTotalPrice() + $total);
				$this->setQuantity($this->getQuantity() + $productDto->getQuantity());

				$this->products->add($productDto);
			}
		}
	}
}