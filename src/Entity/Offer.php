<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\OfferRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: OfferRepository::class)]
class Offer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: 'Veuillez saisir un titre.')]
    #[Assert\Length(
        min: 5,
        max: 150,
        minMessage: 'Le titre doit contenir au moins {{ limit }} caractères.',
        maxMessage: 'Le titre doit contenir au maximum {{ limit }} caractères.'
    )]
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[Assert\NotBlank(message: 'Veuillez saisir une description courte.')]
    #[Assert\Length(
        min: 20,
        max: 255,
        minMessage: 'La description courte doit contenir au moins {{ limit }} caractères.',
        maxMessage: 'La description courte doit contenir au maximum {{ limit }} caractères.'
    )]
    #[ORM\Column(length: 255)]
    private ?string $shortDescription = null;

    #[Assert\NotBlank(message: 'Veuillez saisir une description.')]
    #[Assert\Length(
        min: 20,
        minMessage: 'La description doit contenir au moins {{ limit }} caractères.'
    )]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $CreatedAt = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Veuillez saisir un salaire.')]
    #[Assert\Positive(message: 'Le salaire doit être positif.')]
    private ?int $salary = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Veuillez saisir un lieu de travail.')]
    #[Assert\Length(
        min: 3,
        max: 100,
        minMessage: 'Le lieu de travail doit contenir au moins {{ limit }} caractères.',
        maxMessage: 'Le lieu de travail doit contenir au maximum {{ limit }} caractères.'
    )]
    private ?string $location = null;

    #[ORM\ManyToOne(inversedBy: 'offers')]
    private ?ContractType $contractType = null;

    #[ORM\ManyToOne(inversedBy: 'offers')]
    private ?EntrepriseProfil $entreprise = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isActive = null;

    #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: 'offers')]
    private Collection $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    #[ORM\PrePersist]
    public function prePersist(): void
    {
        $slugify = new Slugify();
        $this->CreatedAt = new \DateTimeImmutable();
        $this->isActive = true;
        $this->slug = $slugify->slugify($this->title) . '' . sha1($this->id);
        
    }

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(string $shortDescription): static
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTimeImmutable $CreatedAt): static
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

    public function getSalary(): ?int
    {
        return $this->salary;
    }

    public function setSalary(int $salary): static
    {
        $this->salary = $salary;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getContractType(): ?ContractType
    {
        return $this->contractType;
    }

    public function setContractType(?ContractType $contractType): static
    {
        $this->contractType = $contractType;

        return $this;
    }

    public function getEntreprise(): ?EntrepriseProfil
    {
        return $this->entreprise;
    }

    public function setEntreprise(?EntrepriseProfil $entreprise): static
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(?bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): static
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }

        return $this;
    }

    public function removeTag(Tag $tag): static
    {
        $this->tags->removeElement($tag);

        return $this;
    }
}
