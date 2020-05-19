<?php

namespace App\Entity\Admin;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Admin\DimensionsProductsRepository")
 * @ORM\Table(name="dimensions_products")
 */
class DimensionsProducts
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

		/**
		 * @ORM\Column(type="string")
		 * @var string
		 */
		private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Admin\Dimension", inversedBy="dimensionsProducts")
     * @ORM\JoinColumn(name="dimension_id", referencedColumnName="id", nullable=false)
     */
    protected $dimension;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Admin\Product", inversedBy="productsDimensions")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=false)
     */
    protected $product;

    public function getId()
    {
        return $this->id;
    }

		public function getPrice(): ?float
		{
				return $this->price;
		}

		public function setPrice(?float $price): void
		{
				$this->price = $price;
		}

    public function getDimension(): ?Dimension
    {
        return $this->dimension;
    }

    public function setDimension(?Dimension $dimension): void
    {
        $this->dimension = $dimension;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): void
    {
        $this->product = $product;
    }
}