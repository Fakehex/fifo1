<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

 /**
 * @ORM\Entity(repositoryClass="App\Repository\BracketRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     "bracket"="Bracket",
  *    "bracketDouble"="BracketDouble",
 *     "bracketDirect"="BracketDirect"
 * })
 */
class Bracket
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Duel", mappedBy="bracket")
     */
    protected $duels;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Tournoi", mappedBy="bracket", cascade={"persist", "remove"})
     */
    protected $tournoi;

    /**
     * @ORM\Column(type="integer")
     */
    protected $tourActuel;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function __construct()
    {
        $this->duels = new ArrayCollection();
    }

    /**
     * @return Collection|Duel[]
     */
    public function getDuels(): Collection
    {
        return $this->duels;
    }

    public function addDuel(Duel $duel): self
    {
        if (!$this->duels->contains($duel)) {
            $this->duels[] = $duel;
            $duel->setBracket($this);
        }

        return $this;
    }

    public function removeDuel(Duel $duel): self
    {
        if ($this->duels->contains($duel)) {
            $this->duels->removeElement($duel);
            // set the owning side to null (unless already changed)
            if ($duel->getBracket() === $this) {
                $duel->setBracket(null);
            }
        }

        return $this;
    }

    public function getTournoi(): ?Tournoi
    {
        return $this->tournoi;
    }

    public function setTournoi(?Tournoi $tournoi): self
    {
        $this->tournoi = $tournoi;

        // set (or unset) the owning side of the relation if necessary
        $newBracket = $tournoi === null ? null : $this;
        if ($newBracket !== $tournoi->getBracket()) {
            $tournoi->setBracket($newBracket);
        }

        return $this;
    }

    public function getTourActuel(): ?int
    {
        return $this->tourActuel;
    }

    public function setTourActuel(int $tourActuel): self
    {
        $this->tourActuel = $tourActuel;

        return $this;
    }

    public function getnbDuelsTour(int $turn, $duels): int {

        $i = 0;

        foreach ($duels as $duel) {
            if ($duel->getTour() == $turn)
                $i++;
        }

        return $i;
    }

    


}
