<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Bracket;
use App\Entity\Duel;

/**
 * @ORM\Entity
 */
class BracketDouble extends Bracket
{


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Duel", mappedBy="bracketDouble")
     */
    private $duelsPerdants;

    /**
     * @ORM\Column(type="integer")
     */
    private $tourPerdant;

    public function __construct()
    {
        parent::__construct();
        $this->duelsPerdants = new ArrayCollection();
    }

    public function addPerdants(Duel $duel): self
    {
        if (!$this->duelsPerdants->contains($duel)) {
            $this->duelsPerdants[] = $duel;
            $duel->setBracket($this);
        }

        return $this;
    }

    public function removePerdants(Duel $duel): self
    {
        if ($this->duelsPerdants->contains($duel)) {
            $this->duelsPerdants->removeElement($duel);
            // set the owning side to null (unless already changed)
            if ($duel->getBracket() === $this) {
                $duel->setBracket(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Duel[]
     */
    public function getDuelsPerdants(): Collection
    {
        return $this->duelsPerdants;
    }

    public function addDuelsPerdant(Duel $duelsPerdant): self
    {
        if (!$this->duelsPerdants->contains($duelsPerdant)) {
            $this->duelsPerdants[] = $duelsPerdant;
            $duelsPerdant->setBracketDouble($this);
        }

        return $this;
    }

    public function removeDuelsPerdant(Duel $duelsPerdant): self
    {
        if ($this->duelsPerdants->contains($duelsPerdant)) {
            $this->duelsPerdants->removeElement($duelsPerdant);
            // set the owning side to null (unless already changed)
            if ($duelsPerdant->getBracketDouble() === $this) {
                $duelsPerdant->setBracketDouble(null);
            }
        }

        return $this;
    }

    public function getTourPerdant(): ?int
    {
        return $this->tourPerdant;
    }

    public function setTourPerdant(int $tourPerdant): self
    {
        $this->tourPerdant = $tourPerdant;

        return $this;
    }


}