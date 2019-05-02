<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DuelRepository")
 */
class Duel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Inscrit", inversedBy="duels")
     */
    private $inscrit1;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Inscrit")
     */
    private $inscrit2;

    /**
     * @ORM\Column(type="integer")
     */
    private $scoreInscrit1;

    /**
     * @ORM\Column(type="integer")
     */
    private $scoreInscrit2;

    /**
     * @ORM\Column(type="integer")
     */
    private $tour;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Bracket", inversedBy="duels")
     */
    private $bracket;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInscrit1(): ?Inscrit
    {
        return $this->inscrit1;
    }

    public function setInscrit1(?Inscrit $inscrit1): self
    {
        $this->inscrit1 = $inscrit1;

        return $this;
    }

    public function getInscrit2(): ?Inscrit
    {
        return $this->inscrit2;
    }

    public function setInscrit2(?Inscrit $inscrit2): self
    {
        $this->inscrit2 = $inscrit2;

        return $this;
    }

    public function getScoreInscrit1(): ?int
    {
        return $this->scoreInscrit1;
    }

    public function setScoreInscrit1(int $scoreInscrit1): self
    {
        $this->scoreInscrit1 = $scoreInscrit1;

        return $this;
    }

    public function getScoreInscrit2(): ?int
    {
        return $this->scoreInscrit2;
    }

    public function setScoreInscrit2(int $scoreInscrit2): self
    {
        $this->scoreInscrit2 = $scoreInscrit2;

        return $this;
    }

    public function getTour(): ?int
    {
        return $this->tour;
    }

    public function setTour(int $tour): self
    {
        $this->tour = $tour;

        return $this;
    }

    public function getGagnant(): ?Inscrit
    {
        if($this->scoreInscrit1 < $this->scoreInscrit2){
            return $this->inscrit2;
        }
        else{
            return $this->inscrit1;
        }
    }

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
