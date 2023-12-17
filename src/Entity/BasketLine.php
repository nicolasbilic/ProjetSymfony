<?php

namespace App\Entity;

use App\Repository\BasketLineRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BasketLineRepository::class)]
class BasketLine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $id_basket_line = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private ?int $quantity = null;

    #[ORM\ManyToOne(inversedBy: 'basket_line')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Basket $basket = null;

    #[ORM\ManyToOne(inversedBy: 'basketLines')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdBasketLine(): ?int
    {
        return $this->id_basket_line;
    }

    public function setIdBasketLine(int $id_basket_line): static
    {
        $this->id_basket_line = $id_basket_line;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getBasket(): ?Basket
    {
        return $this->basket;
    }

    public function setBasket(?Basket $basket): static
    {
        $this->basket = $basket;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }
}
