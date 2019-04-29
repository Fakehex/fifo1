<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MatchRepository")
 */
class Match
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Inscrit", inversedBy="matches")
     */
    private $inscrit1;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Inscrit")
     */
    private $inscrit2;

    /**
     * @ORM\Column(type="integer")
     */
    private $scoreEquipe1;

    /**
     * @ORM\Column(type="integer")
     */
    private $scoreEquipe2;

    /**
     * @ORM\Column(type="integer")
     */
    private $tour;

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

    public function getScoreEquipe1(): ?int
    {
        return $this->scoreEquipe1;
    }
    public function getScoreEquipe2(): ?int
    {
        return $this->scoreEquipe2;
    }


    public function setScore(int $score1, int $score2): self
    {
        $this->scoreEquipe1 = $score1;
        $this->scoreEquipe2 = $score2;

        return $this;
    }
    public function setScoreEquipe1(int $score): self
    {
        $this->scoreEquipe1 = $score;

        return $this;
    }

    public function setScoreEquipe2(int $score): self
    {
        $this->scoreEquipe2 = $score;

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
        if($this->scoreEquipe1 < $this->scoreEquipe2){
            return $this->inscrit2;
        }
        else{
            return $this->inscrit1;
        }
    }

}
