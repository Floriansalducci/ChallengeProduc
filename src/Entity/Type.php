<?php

namespace App\Entity;

use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypeRepository::class)
 */
class Type
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="type")
     */
    private $Product_type;

    /**
     * @ORM\ManyToOne(targetEntity=Discount::class, inversedBy="Type")
     */
    private $discount;

    public function __construct()
    {
        $this->Product_type = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProductType(): Collection
    {
        return $this->Product_type;
    }

    public function addProductType(Product $productType): self
    {
        if (!$this->Product_type->contains($productType)) {
            $this->Product_type[] = $productType;
            $productType->setType($this);
        }

        return $this;
    }

    public function removeProductType(Product $productType): self
    {
        if ($this->Product_type->removeElement($productType)) {
            // set the owning side to null (unless already changed)
            if ($productType->getType() === $this) {
                $productType->setType(null);
            }
        }

        return $this;
    }

    /**
     * @param ArrayCollection $Product_type
     */
    public function setProductType(ArrayCollection $Product_type): void
    {
        $this->Product_type = $Product_type;
    }

    public function getDiscount(): ?Discount
    {
        return $this->discount;
    }

    public function setDiscount(?Discount $discount): self
    {
        $this->discount = $discount;

        return $this;
    }
}
