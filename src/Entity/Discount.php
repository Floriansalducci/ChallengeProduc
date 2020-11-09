<?php

namespace App\Entity;

use App\Repository\DiscountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DiscountRepository::class)
 */
class Discount
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
    private $rule_expression;


    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Regex(
     *     pattern= "/^(?:[1-9]|[1-4][0-9]|50)$/",
     *     message= "La réduction doit être entre 1 et 50 %")
     */
    private $discount_percent;

    /**
     * @ORM\OneToMany(targetEntity=Type::class, mappedBy="discount")
     */
    private $Type;

    public function __construct()
    {
        $this->Type = new ArrayCollection();
    }

    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRuleExpression(): ?string
    {
        return $this->rule_expression;
    }

    public function setRuleExpression(string $rule_expression): self
    {
        $this->rule_expression = $rule_expression;

        return $this;
    }


    public function getDiscountPercent(): ?int
    {
        return $this->discount_percent;
    }

    public function setDiscountPercent(?int $discount_percent): self
    {
        $this->discount_percent = $discount_percent;

        return $this;
    }

    /**
     * @return Collection|Type[]
     */
    public function getType(): Collection
    {
        return $this->Type;
    }

    public function addType(Type $type): self
    {
        if (!$this->Type->contains($type)) {
            $this->Type[] = $type;
            $type->setDiscount($this);
        }

        return $this;
    }

    public function removeType(Type $type): self
    {
        if ($this->Type->removeElement($type)) {
            // set the owning side to null (unless already changed)
            if ($type->getDiscount() === $this) {
                $type->setDiscount(null);
            }
        }

        return $this;
    }



}
