<?php

namespace App\Entity\Admin;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Admin\CategoryRepository")
 */
class Category implements TranslatableInterface
{
    use TranslatableTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Admin\ProductsCategories", mappedBy="category", cascade={"persist"})
     */
    private $categoriesProducts;

    public function __construct()
    {
        $this->categoriesProducts = new ArrayCollection();
    }

    public function __call($method, $arguments)
    {
        return PropertyAccess::createPropertyAccessor()->getValue($this->translate(), $method);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->__call('getName', []);
    }

    public function setName($name): ?string
    {
        return $this->__call('setName', [$name]);
    }

    /**
     * @return Collection|Product[]
     */
    public function getCategoriesProduct(): Collection
    {
        return $this->categoriesProducts;
    }

    public function addCategoriesProduct(ProductsCategories $categoriesProducts): self
    {
        if (!$this->categoriesProducts->contains($categoriesProducts)) {
            $this->categoriesProducts[] = $categoriesProducts;
            $categoriesProducts->setCategory($this);
        }

        return $this;
    }

    public function removeCategoriesProduct(ProductsCategories $categoriesProducts): self
    {
        if ($this->categoriesProducts->contains($categoriesProducts)) {
            $this->categoriesProducts->removeElement($categoriesProducts);
        }

        return $this;
    }
}
