<?php

namespace App\Entity\Admin;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Admin\DimensionRepository")
 */
class Dimension implements TranslatableInterface
{
    use TranslatableTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Admin\DimensionsProducts", mappedBy="dimension", cascade={"persist"})
     */
    private $dimensionsProducts;

    public function __construct()
    {
        $this->dimensionsProducts = new ArrayCollection();
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

    /**
     * @return Collection|Dimension[]
     */
    public function getDimensionsProducts(): Collection
    {
        return $this->dimensionsProducts;
    }

    public function addDimensionsProduct(DimensionsProducts $dimensionsProducts): self
    {
        if (!$this->dimensionsProducts->contains($dimensionsProducts)) {
            $this->dimensionsProducts[] = $dimensionsProducts;
            $dimensionsProducts->setDimension($this);
        }

        return $this;
    }

    public function removeDimensionsProduct(DimensionsProducts $dimensionsProducts): self
    {
        if ($this->dimensionsProducts->contains($dimensionsProducts)) {
            $this->dimensionsProducts->removeElement($dimensionsProducts);
            $dimensionsProducts->setDimension(null);
        }

        return $this;
    }
}
