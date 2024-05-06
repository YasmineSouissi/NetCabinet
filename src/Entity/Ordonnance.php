<?php

namespace App\Entity;

use App\Repository\OrdonnanceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrdonnanceRepository::class)]
class Ordonnance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, medicament>
     */
    #[ORM\ManyToMany(targetEntity: Medicament::class, inversedBy: 'ordonnances')]
    private Collection $medicament;

    public function __construct()
    {
        $this->medicament = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, medicament>
     */
    public function getMedicament(): Collection
    {
        return $this->medicament;
    }

    public function addMedicament(medicament $medicament): static
    {
        if (!$this->medicament->contains($medicament)) {
            $this->medicament->add($medicament);
        }

        return $this;
    }

    public function removeMedicament(medicament $medicament): static
    {
        $this->medicament->removeElement($medicament);

        return $this;
    }
}
