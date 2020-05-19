<?php

namespace App\Entity\Admin;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class OrderProduct
{
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $quantity;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Admin\Order", inversedBy="orderProducts")
	 */
	private $orderItem;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Admin\Product")
	 * @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=false)
	 */
	private $product;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Admin\DimensionsProducts")
	 * @ORM\JoinColumn(name="dimensions_products_id", referencedColumnName="id", nullable=false)
	 */
	private $productsDimensions;

	public function getId()
	{
		return $this->id;
	}

	public function getQuantity()
	{
		return $this->quantity;
	}

	public function setQuantity($quantity): void
	{
		$this->quantity = $quantity;
	}

	public function getOrderItem()
	{
		return $this->orderItem;
	}

	public function setOrderItem($orderItem): void
	{
		$this->orderItem = $orderItem;
	}

	public function getProduct()
	{
		return $this->product;
	}

	public function setProduct($product): void
	{
		$this->product = $product;
	}

	public function getProductsDimensions()
	{
		return $this->productsDimensions;
	}

	public function setProductsDimensions($productsDimensions): void
	{
		$this->productsDimensions = $productsDimensions;
	}
}