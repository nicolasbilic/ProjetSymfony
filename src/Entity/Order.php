<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $total = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $date = null;

    #[ORM\Column]
    private ?float $shipping_price = null;

    #[ORM\OneToMany(mappedBy: 'order_customer', targetEntity: OrderLine::class, orphanRemoval: true)]
    private Collection $order_line;

    #[ORM\OneToOne(inversedBy: 'order_customer', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Basket $basket = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?OrderState $order_state = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Address $shipping_address = null;

    #[ORM\ManyToOne(inversedBy: 'invoice_address')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Address $invoice_address = null;

    #[ORM\ManyToOne(inversedBy: 'order_customer')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Customer $customer = null;

    public function __construct()
    {
        $this->order_line = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): static
    {
        $this->total = $total;

        return $this;
    }

    public function getDate(): ?DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getShippingPrice(): ?float
    {
        return $this->shipping_price;
    }

    public function setShippingPrice(float $shipping_price): static
    {
        $this->shipping_price = $shipping_price;

        return $this;
    }

    /**
     * @return Collection<int, OrderLine>
     */
    public function getOrderLine(): Collection
    {
        return $this->order_line;
    }

    public function addOrderLine(OrderLine $orderLine): static
    {
        if (!$this->order_line->contains($orderLine)) {
            $this->order_line->add($orderLine);
            $orderLine->setOrderCustomer($this);
        }

        return $this;
    }

    public function removeOrderLine(OrderLine $orderLine): static
    {
        if ($this->order_line->removeElement($orderLine)) {
            // set the owning side to null (unless already changed)
            if ($orderLine->getOrderCustomer() === $this) {
                $orderLine->setOrderCustomer(null);
            }
        }

        return $this;
    }

    public function getBasket(): ?Basket
    {
        return $this->basket;
    }

    public function setBasket(Basket $basket): static
    {
        $this->basket = $basket;

        return $this;
    }

    public function getOrderState(): ?OrderState
    {
        return $this->order_state;
    }

    public function setOrderState(?OrderState $order_state): static
    {
        $this->order_state = $order_state;

        return $this;
    }

    public function getShippingAddress(): ?Address
    {
        return $this->shipping_address;
    }

    public function setShippingAddress(?Address $shipping_address): static
    {
        $this->shipping_address = $shipping_address;

        return $this;
    }

    public function getInvoiceAddress(): ?Address
    {
        return $this->invoice_address;
    }

    public function setInvoiceAddress(?Address $invoice_address): static
    {
        $this->invoice_address = $invoice_address;

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
}
