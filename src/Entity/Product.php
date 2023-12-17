<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_product = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le champ doit être renseigné')]
    #[Assert\Type(type: 'string', message: 'Le champ doit être une chaîne de caractères')]
    private ?string $name = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Le champ doit être renseigné')]
    #[Assert\Type(type: 'float', message: 'Le champ doit être un nombre avec décimales')]
    private ?float $price = null;

    #[ORM\Column(length: 500, nullable: true)]
    #[Assert\NotBlank(message: 'Le champ doit être renseigné')]
    #[Assert\Type(type: 'string', message: 'Le champ doit être une chaîne de caractères')]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Type(type: 'float', message: 'Le champ doit être un nombre avec décimales')]
    private ?float $discount = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Le champ doit être renseigné')]
    #[Assert\Type(type: 'integer', message: 'Le champ doit être un nombre entier')]
    private ?int $stock = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: BasketLine::class, orphanRemoval: true)]
    private Collection $basketLines;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(name: 'id_category', referencedColumnName: 'id_category', nullable: false)]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(name: 'id_tva', referencedColumnName: 'id_tva', nullable: false)]
    private ?Tva $tva = null;

    public function __construct()
    {
        $this->basketLines = new ArrayCollection();
    }

    public function getIdProduct(): ?int
    {
        return $this->id_product;
    }

    public function setIdProduct(int $id_product): static
    {
        $this->id_product = $id_product;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    public function setDiscount(?float $discount): static
    {
        $this->discount = $discount;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * @return Collection<int, BasketLine>
     */
    public function getBasketLines(): Collection
    {
        return $this->basketLines;
    }

    public function addBasketLine(BasketLine $basketLine): static
    {
        if (!$this->basketLines->contains($basketLine)) {
            $this->basketLines->add($basketLine);
            $basketLine->setProduct($this);
        }

        return $this;
    }

    public function removeBasketLine(BasketLine $basketLine): static
    {
        if ($this->basketLines->removeElement($basketLine)) {
            // set the owning side to null (unless already changed)
            if ($basketLine->getProduct() === $this) {
                $basketLine->setProduct(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getTva(): ?Tva
    {
        return $this->tva;
    }

    public function setTva(?Tva $tva): static
    {
        $this->tva = $tva;

        return $this;
    }
}
