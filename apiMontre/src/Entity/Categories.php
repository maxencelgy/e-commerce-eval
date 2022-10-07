<?php

namespace App\Entity;

use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriesRepository::class)]
class Categories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'categories', targetEntity: Montres::class)]
    private Collection $montres;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    public function __construct()
    {
        $this->montres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Montres>
     */
    public function getMontres(): Collection
    {
        return $this->montres;
    }

    public function addMontre(Montres $montre): self
    {
        if (!$this->montres->contains($montre)) {
            $this->montres->add($montre);
            $montre->setCategories($this);
        }

        return $this;
    }

    public function removeMontre(Montres $montre): self
    {
        if ($this->montres->removeElement($montre)) {
            // set the owning side to null (unless already changed)
            if ($montre->getCategories() === $this) {
                $montre->setCategories(null);
            }
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;
        return $this;
    }
}
