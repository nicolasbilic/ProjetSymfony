<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReviewRepository::class)]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le champ doit être renseigné')]
    #[Assert\Type(type: 'string', message: 'Le champ doit être une chaîne de caractères')]
    private ?string $title = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Le champ doit être renseigné')]
    #[Assert\Type(type: 'integer', message: 'Le champ doit être un nombre entier')]
    #[Assert\Range(
        min: 1,
        max: 5,
        notInRangeMessage: 'La note doit être comprise entre {{ min } } and {{ max }}.',
    )]
    private ?int $value = null;

    #[ORM\Column(length: 500)]
    #[Assert\NotBlank(message: 'Le champ doit être renseigné')]
    #[Assert\Type(type: 'string', message: 'Le champ doit être une chaîne de caractères')]
    private ?string $resume = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Le champ doit être renseigné')]
    private ?string $state = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $date_review = null;

    #[ORM\Column(length: 45)]
    private ?string $userFirstName = null;

    #[ORM\Column(length: 45)]
    private ?string $userLastName = null;

    #[ORM\Column(nullable: true)]
    private ?int $user_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(string $resume): static
    {
        $this->resume = $resume;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): static
    {
        $this->state = $state;

        return $this;
    }

    public function getDateReview(): ?\DateTimeImmutable
    {
        return $this->date_review;
    }

    public function setDateReview(\DateTimeImmutable $date_review): static
    {
        $this->date_review = $date_review;

        return $this;
    }

    public function getUserFirstName(): ?string
    {
        return $this->userFirstName;
    }

    public function setUserFirstName(string $userFirstName): static
    {
        $this->userFirstName = $userFirstName;

        return $this;
    }

    public function getUserLastName(): ?string
    {
        return $this->userLastName;
    }

    public function setUserLastName(string $userLastName): static
    {
        $this->userLastName = $userLastName;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(?int $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }
}
