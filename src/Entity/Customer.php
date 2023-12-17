<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
class Customer
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_customer = null;

    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 50)]
    private ?string $firstname = null;

    #[ORM\ManyToOne(inversedBy: 'customers')]
    private ?Address $address = null;

    #[ORM\OneToMany(mappedBy: 'customer', targetEntity: Order::class)]
    private Collection $order_customer;

    #[ORM\OneToMany(mappedBy: 'customer', targetEntity: Basket::class)]
    private Collection $basket;

    public function __construct()
    {
        $this->order_customer = new ArrayCollection();
        $this->basket = new ArrayCollection();
    }

    public function getIdCustomer(): ?int
    {
        return $this->id_customer;
    }

    public function setIdCustomer(int $id_customer): static
    {
        $this->id_customer = $id_customer;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): static
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrderCustomer(): Collection
    {
        return $this->order_customer;
    }

    public function addOrderCustomer(Order $orderCustomer): static
    {
        if (!$this->order_customer->contains($orderCustomer)) {
            $this->order_customer->add($orderCustomer);
            $orderCustomer->setCustomer($this);
        }

        return $this;
    }

    public function removeOrderCustomer(Order $orderCustomer): static
    {
        if ($this->order_customer->removeElement($orderCustomer)) {
            // set the owning side to null (unless already changed)
            if ($orderCustomer->getCustomer() === $this) {
                $orderCustomer->setCustomer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Basket>
     */
    public function getBasket(): Collection
    {
        return $this->basket;
    }

    public function addBasket(Basket $basket): static
    {
        if (!$this->basket->contains($basket)) {
            $this->basket->add($basket);
            $basket->setCustomer($this);
        }

        return $this;
    }

    public function removeBasket(Basket $basket): static
    {
        if ($this->basket->removeElement($basket)) {
            // set the owning side to null (unless already changed)
            if ($basket->getCustomer() === $this) {
                $basket->setCustomer(null);
            }
        }

        return $this;
    }
}
