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

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Veuillez rentrer un nom de catégorie.')]
    #[Assert\NotNull(message: 'Veuillez rentrer un nom de catégorie.')]
    #[Assert\Type('string')]
    #[Assert\NoSuspiciousCharacters]
    #[Assert\Length(max: 50)]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z0-9\s\'’-]+$/u',
        message: 'Le nom de catégorie ne peut contenir que des lettres, chiffres, tirets ou apostrophes.'
    )]
    private ?string $name = null;

    #[ORM\Column(length: 500, nullable: true)]
    #[Assert\Type('string')]
    #[Assert\NoSuspiciousCharacters]
    #[Assert\Length(max: 500)]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z0-9\s\'’-]+$/u',
        message: 'La description de la catégorie ne peut contenir que des lettres, chiffres, tirets ou apostrophes.'
    )]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Product::class)]
    private Collection $products;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'subcategory')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Category $parent = null;

    #[ORM\OneToMany(targetEntity: Category::class, mappedBy: 'parent')]
    private Collection $subcategory;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->subcategory = new ArrayCollection();
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

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getSubcategories(): Collection
    {
        return $this->subcategory;
    }


    public function addSubcategory(Category $child): self
    {
        if (!$this->subcategory->contains($child)) {
            $this->subcategory[] = $child;
            $child->setParent($this);
        }

        return $this;
    }

    public function removeSubcategory(Category $child): self
    {
        if ($this->subcategory->removeElement($child)) {
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
    }
}
