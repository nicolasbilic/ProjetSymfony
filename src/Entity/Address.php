<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
class Address
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Veuillez rentrer un numéro de rue.')]
    #[Assert\NotNull(message: 'Veuillez rentrer un numéro de rue.')]
    #[Assert\Type('integer', message: 'Veuillez rentrer un nombre.')]
    private ?int $number = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Veuillez rentrer une rue.')]
    #[Assert\NotNull(message: 'Veuillez rentrer une rue.')]
    #[Assert\Type('string')]
    #[Assert\NoSuspiciousCharacters]
    #[Assert\Length(max: 255)]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z0-9\s\'’-]+$/u',
        message: 'Le nom de rue ne peut contenir que des lettres, chiffres, tirets ou apostrophes.'
    )]
    private ?string $street = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Type('string')]
    #[Assert\NoSuspiciousCharacters]
    #[Assert\Length(max: 255)]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z0-9\s\'’-]+$/u',
        message: 'Le complément d\'adresse ne peut contenir que des lettres, chiffres, tirets ou apostrophes.'
    )]
    private ?string $additional = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Veuillez rentrer une ville.')]
    #[Assert\NotNull(message: 'Veuillez rentrer une ville.')]
    #[Assert\Type('string')]
    #[Assert\NoSuspiciousCharacters]
    #[Assert\Length(max: 50)]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z\s\'’-]+$/u',
        message: 'La ville ne peut contenir que des lettres, tirets ou apostrophes.'
    )]
    private ?string $city = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Veuillez rentrer un code postal.')]
    #[Assert\NotNull(message: 'Veuillez rentrer un code postal.')]
    #[Assert\Type('integer', message: 'Veuillez rentrer un nombre.')]
    #[Assert\Regex(
        pattern: '/^\d{5}$/',
        message: 'Le code postal doit comporter exactement 5 chiffres.'
    )]
    private ?int $zip_code = null;

    #[ORM\OneToMany(mappedBy: 'address', targetEntity: Customer::class)]
    private Collection $customers;

    #[ORM\OneToMany(mappedBy: 'shipping_address', targetEntity: Order::class)]
    private Collection $orders;

    #[ORM\OneToMany(mappedBy: 'invoice_address', targetEntity: Order::class)]
    private Collection $invoice_address;

    public function __construct()
    {
        $this->customers = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->invoice_address = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setIdAddress(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): static
    {
        $this->street = $street;

        return $this;
    }

    public function getAdditional(): ?string
    {
        return $this->additional;
    }

    public function setAdditional(string $additional): static
    {
        $this->additional = $additional;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getZipCode(): ?int
    {
        return $this->zip_code;
    }

    public function setZipCode(int $zip_code): static
    {
        $this->zip_code = $zip_code;

        return $this;
    }

    /**
     * @return Collection<int, Customer>
     */
    public function getCustomers(): Collection
    {
        return $this->customers;
    }

    public function addCustomer(Customer $customer): static
    {
        if (!$this->customers->contains($customer)) {
            $this->customers->add($customer);
            $customer->setAddress($this);
        }

        return $this;
    }

    public function removeCustomer(Customer $customer): static
    {
        if ($this->customers->removeElement($customer)) {
            // set the owning side to null (unless already changed)
            if ($customer->getAddress() === $this) {
                $customer->setAddress(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): static
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setShippingAddress($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): static
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getShippingAddress() === $this) {
                $order->setShippingAddress(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getInvoiceAddress(): Collection
    {
        return $this->invoice_address;
    }

    public function addInvoiceAddress(Order $invoiceAddress): static
    {
        if (!$this->invoice_address->contains($invoiceAddress)) {
            $this->invoice_address->add($invoiceAddress);
            $invoiceAddress->setInvoiceAddress($this);
        }

        return $this;
    }

    public function removeInvoiceAddress(Order $invoiceAddress): static
    {
        if ($this->invoice_address->removeElement($invoiceAddress)) {
            // set the owning side to null (unless already changed)
            if ($invoiceAddress->getInvoiceAddress() === $this) {
                $invoiceAddress->setInvoiceAddress(null);
            }
        }

        return $this;
    }
}
