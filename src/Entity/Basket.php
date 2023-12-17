<?php

namespace App\Entity;

use App\Repository\BasketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BasketRepository::class)]
class Basket
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_basket = null;

    #[ORM\OneToOne(mappedBy: 'basket', cascade: ['persist', 'remove'])]
    private ?Order $order_customer = null;

    #[ORM\ManyToOne(inversedBy: 'basket')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Customer $customer = null;

    #[ORM\OneToMany(mappedBy: 'basket', targetEntity: BasketLine::class)]
    private Collection $basket_line;

    public function __construct()
    {
        $this->basket_line = new ArrayCollection();
    }


    public function getIdBasket(): ?int
    {
        return $this->id_basket;
    }

    public function setIdBasket(int $id_basket): static
    {
        $this->id_basket = $id_basket;

        return $this;
    }

    public function getOrderCustomer(): ?Order
    {
        return $this->order_customer;
    }

    public function setOrderCustomer(Order $order_customer): static
    {
        // set the owning side of the relation if necessary
        if ($order_customer->getBasket() !== $this) {
            $order_customer->setBasket($this);
        }

        $this->order_customer = $order_customer;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): static
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return Collection<int, BasketLine>
     */
    public function getBasketLine(): Collection
    {
        return $this->basket_line;
    }

    public function addBasketLine(BasketLine $basketLine): static
    {
        if (!$this->basket_line->contains($basketLine)) {
            $this->basket_line->add($basketLine);
            $basketLine->setBasket($this);
        }

        return $this;
    }

    public function removeBasketLine(BasketLine $basketLine): static
    {
        if ($this->basket_line->removeElement($basketLine)) {
            // set the owning side to null (unless already changed)
            if ($basketLine->getBasket() === $this) {
                $basketLine->setBasket(null);
            }
        }

        return $this;
    }
}
