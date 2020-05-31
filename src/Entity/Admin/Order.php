<?php

namespace App\Entity\Admin;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Admin\OrderRepository")
 * @ORM\Table(name="order_item")
 */
class Order
{
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $street;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $house;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $flat;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $floor;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $name;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $surname;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $email;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $phone;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $notes;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $payMethod;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $delivery;

	/**
	 * @ORM\Column(type="string")
	 */
	private $totalPrice;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $orderDate;

	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\Admin\OrderProduct", mappedBy="orderItem", cascade={"persist"})
	 */
	private $orderProducts;

	public function __construct()
	{
		$this->orderProducts = new ArrayCollection();
		$this->orderDate = new \DateTime();
	}

	public function getId()
	{
		return $this->id;
	}

	public function getStreet()
	{
		return $this->street;
	}

	public function setStreet($street): void
	{
		$this->street = $street;
	}

	public function getHouse()
	{
		return $this->house;
	}

	public function setHouse($house): void
	{
		$this->house = $house;
	}

	public function getFlat()
	{
		return $this->flat;
	}

	public function setFlat($flat): void
	{
		$this->flat = $flat;
	}

	public function getFloor()
	{
		return $this->floor;
	}

	public function setFloor($floor): void
	{
		$this->floor = $floor;
	}

	public function getName()
	{
		return $this->name;
	}

	public function setName($name): void
	{
		$this->name = $name;
	}

	public function getSurname()
	{
		return $this->surname;
	}

	public function setSurname($surname): void
	{
		$this->surname = $surname;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function setEmail($email): void
	{
		$this->email = $email;
	}

	public function getPhone()
	{
		return $this->phone;
	}

	public function setPhone($phone): void
	{
		$this->phone = $phone;
	}

	public function getNotes()
	{
		return $this->notes;
	}

	public function setNotes($notes): void
	{
		$this->notes = $notes;
	}

	public function getPayMethod()
	{
		return $this->payMethod;
	}

	public function setPayMethod($payMethod): void
	{
		$this->payMethod = $payMethod;
	}

	public function getDelivery()
	{
		return $this->delivery;
	}

	public function setDelivery($delivery): void
	{
		$this->delivery = $delivery;
	}

	public function getTotalPrice()
	{
		return $this->totalPrice;
	}

	public function setTotalPrice($totalPrice): void
	{
		$this->totalPrice = $totalPrice;
	}

	public function getOrderDate(): \DateTime
	{
		return $this->orderDate;
	}

	/**
	 * @return Collection|OrderProduct[]
	 */
	public function getOrderProducts(): Collection
	{
		return $this->orderProducts;
	}

	public function addOrderProduct(OrderProduct $orderProduct): self
	{
		if (!$this->orderProducts->contains($orderProduct)) {
			$this->orderProducts[] = $orderProduct;
			$orderProduct->setOrderItem($this);
		}

		return $this;
	}

	public function removeOrderProduct(OrderProduct $orderProduct): self
	{
		if ($this->orderProducts->contains($orderProduct)) {
			$this->orderProducts->removeElement($orderProduct);
		}

		return $this;
	}
}