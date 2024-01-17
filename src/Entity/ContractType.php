<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ContractTypeRepository;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: ContractTypeRepository::class)]
class ContractType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: 'Le nom est obligatoire')]
    #[Assert\Length(max: 20, maxMesssage: 'Le nom du mot clé ne peut pas dépasser {{ limit }} caractéres.')]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $slug = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\PrePersist]
    public function PrePersist(): void
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->slug = (new Slugify())->slugify($this->name);
    }

    #[ORM\PreUpdate]
    public function preUpdate(): void
    {
        $this->slug = (new Slugify())->slugify($this->name);
    }



    public function getId(): ?int
    {
        return $this->id;
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
