<?php

namespace App\Entity;

use App\Repository\AdminRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AdminRepository::class)]
class Admin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\Type('integer')]
    private ?int $id_admin = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Regex(
        pattern: '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
        message: 'Il te faut au moins une majuscule, une minuscule, un chiffre et un caractère spécial',
    )]
    #[Assert\Length(
        min: 8,
        minMessage: 'Ton mot de passe doit contenir au moins {{ limit }} caractères',
    )]
    private ?string $password = null;

    #[ORM\Column(length: 50)]
    #[Assert\Type('string')]
    private ?string $name = null;

    #[ORM\Column(length: 50)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    #[Assert\Email('Veuillez entrer une adresse email valide')]
    #[Assert\NotBlank]
    #[Assert\NoSuspiciousCharacters]
    #[Assert\Unique('Cette adresse email est déjà utilisée')]
    private ?string $mail = null;

    #[ORM\ManyToOne(inversedBy: 'admins')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Role $role = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdAdmin(): ?int
    {
        return $this->id_admin;
    }

    public function setIdAdmin(int $id_admin): static
    {
        $this->id_admin = $id_admin;

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

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): static
    {
        $this->role = $role;

        return $this;
    }
}
