<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Tournoi extends Evenement
{

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Bracket", inversedBy="tournoi", cascade={"persist", "remove"})
     */
    private $bracket;

    public function getBracket(): ?Bracket
    {
        return $this->bracket;
    }

    public function setBracket(?Bracket $bracket): self
    {
        $this->bracket = $bracket;

        return $this;
    }
}
