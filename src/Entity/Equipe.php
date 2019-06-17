<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Inscrit;

/**
 * @ORM\Entity
 */
class Equipe extends Inscrit
{

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Joueur", mappedBy="equipe", orphanRemoval=true)
     */
    private $Joueurs;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Joueur", cascade={"persist","remove"}, orphanRemoval=true)
     */
    private $leader;

    public function __construct()
    {
        $this->Joueurs = new ArrayCollection();
    }


    /**
     * @return Collection|Joueur[]
     */
    public function getJoueurs(): Collection
    {
        return $this->Joueurs;
    }

    public function addJoueur(Joueur $joueur): self
    {
        if (!$this->Joueurs->contains($joueur)) {
            $this->Joueurs[] = $joueur;
            $joueur->setEquipe($this);
        }

        return $this;
    }

    public function removeJoueur(Joueur $joueur): self
    {
        if ($this->Joueurs->contains($joueur)) {
            $this->Joueurs->removeElement($joueur);
            // set the owning side to null (unless already changed)
            if ($joueur->getEquipe() === $this) {
                $joueur->setEquipe(null);
            }
        }

        return $this;
    }

    public function getLeader(): ?Joueur
    {
        return $this->leader;
    }

    public function setLeader(?Joueur $leader): self
    {
        $this->leader = $leader;

        return $this;
    }
}
