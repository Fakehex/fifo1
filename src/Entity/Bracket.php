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
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Duel", mappedBy="bracket")
     */
    private $duels;

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

    


}
