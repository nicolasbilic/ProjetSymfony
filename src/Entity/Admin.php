<?php

namespace App\Entity;

use App\Repository\AdminRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AdminRepository::class)]
#[ORM\Table(name: '`admin`')]
class Admin implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank(message: 'Veuillez rentrer un email.')]
    #[Assert\NotNull(message: 'Veuillez rentrer un email.')]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    #[Assert\Unique('Cette adresse email est déjà utilisée')]
    #[Assert\NoSuspiciousCharacters]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\NotBlank(message: 'Veuillez rentrer un mot de passe.')]
    #[Assert\NotNull(message: 'Veuillez rentrer un mot de passe.')]
    #[Assert\Type('string')]
    #[Assert\NoSuspiciousCharacters]
    #[Assert\Length(
        min: 8,
        minMessage: 'Votre mot de passe doit contenir au moins {{ limit }} caractères.',
    )]
    #[Assert\Regex(
        pattern: '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
        message: 'Le mot de passe requiert au moins une majuscule, une minuscule, un chiffre et un caractère spécial',
    )]
    private ?string $password = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Veuillez rentrer un Nom.')]
    #[Assert\NotNull(message: 'Veuillez rentrer un Nom.')]
    #[Assert\Type('string')]
    #[Assert\NoSuspiciousCharacters]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'Votre nom doit contenir au moins {{ limit }} caractères',
        maxMessage: 'Votre nom doit contenir au maximum {{ limit }} caractères',
    )]
    // Compatible avec des noms internationaux
    #[Assert\Regex(
        pattern: "/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùæúûüųūÿýżźñçÞčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/u",
        message: 'Votre nom doit être constitué exclusivement de caractères alphabétiques.'
    )]
    private ?string $name = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Veuillez rentrer un Prénom.')]
    #[Assert\NotNull(message: 'Veuillez rentrer un Prénom.')]
    #[Assert\Type('string')]
    #[Assert\NoSuspiciousCharacters]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'Votre prénom doit contenir au moins {{ limit }} caractères',
        maxMessage: 'Votre prénom doit contenir au maximum {{ limit }} caractères',
    )]
    #[Assert\Regex(
        pattern: "/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùæúûüųūÿýżźñçÞčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/u",
        message: 'Votre prénom doit être constitué exclusivement de caractères alphabétiques.'
    )]
    private ?string $firstname = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
}
