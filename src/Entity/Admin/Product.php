<?php

namespace App\Entity\Admin;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Admin\ProductRepository")
 * @Vich\Uploadable
 */
class Product implements TranslatableInterface
{
    use TranslatableTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="product_image", fileNameProperty="image")
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTimeInterface|null
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Admin\ProductsCategories", mappedBy="product", cascade={"persist"}, orphanRemoval=true)
     */
    private $productsCategories;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Admin\DimensionsProducts", mappedBy="product", cascade={"persist"}, orphanRemoval=true)
     */
    private $productsDimensions;

    public function __construct()
    {
        $this->productsCategories = new ArrayCollection();
        $this->productsDimensions = new ArrayCollection();
    }

    public function __call($method, $arguments)
    {
        return PropertyAccess::createPropertyAccessor()->getValue($this->translate(), $method);
    }

    public function getName(): ?string
    {
        return $this->__call('getName', []);
    }

    public function getDescription(): ?string
    {
        return $this->__call('getDescription', []);
    }

    public function getPrice(): ?string
    {
        return $this->__call('getPrice', []);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    /**
     * @return Collection|Category[]
     */
    public function getProductsCategories(): Collection
    {
        return $this->productsCategories;
    }

    public function addProductsCategory(ProductsCategories $productsCategories): self
    {
        if (!$this->productsCategories->contains($productsCategories)) {
            $this->productsCategories[] = $productsCategories;
            $productsCategories->setProduct($this);
        }

        return $this;
    }

    public function removeProductsCategory(ProductsCategories $productsCategories): self
    {
        if ($this->productsCategories->contains($productsCategories)) {
            $this->productsCategories->removeElement($productsCategories);
            if ($productsCategories->getProduct() === $this) {
                $productsCategories->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Dimension[]
     */
    public function getProductsDimensions(): Collection
    {
        return $this->productsDimensions;
    }

    public function addProductsDimension(DimensionsProducts $productsDimensions): self
    {
        if (!$this->productsDimensions->contains($productsDimensions)) {
            $this->productsDimensions[] = $productsDimensions;
            $productsDimensions->setProduct($this);
        }

        return $this;
    }

    public function removeProductsDimension(DimensionsProducts $productsDimensions): self
    {
        if ($this->productsDimensions->contains($productsDimensions)) {
            $this->productsDimensions->removeElement($productsDimensions);
            if ($productsDimensions->getProduct() === $this) {
                $productsDimensions->setProduct(null);
            }
        }

        return $this;
    }
}
