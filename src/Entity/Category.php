<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $id_category = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Product::class)]
    private Collection $products;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'subcategory')]
    private ?self $subcategory = null;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        //$this->subcategory = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCategory(): ?int
    {
        return $this->id_category;
    }

    public function setIdCategory(int $id_category): static
    {
        $this->id_category = $id_category;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setCategory($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getCategory() === $this) {
                $product->setCategory(null);
            }
        }

        return $this;
    }

    public function getSubcategory(): ?self
    {
        return $this->subcategory;
    }

    public function setSubcategory(?self $subcategory): static
    {
        $this->subcategory = $subcategory;

        return $this;
    }

    public function addSubcategory(self $subcategory): static
    {
        if (!$this->subcategory->contains($subcategory)) {
            $this->subcategory->add($subcategory);
            $subcategory->setSubcategory($this);
        }

        return $this;
    }

    public function removeSubcategory(self $subcategory): static
    {
        if ($this->subcategory->removeElement($subcategory)) {
            // set the owning side to null (unless already changed)
            if ($subcategory->getSubcategory() === $this) {
                $subcategory->setSubcategory(null);
            }
        }

        return $this;
    }
}
