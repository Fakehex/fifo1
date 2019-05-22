<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;


/**
* @ORM\Entity(repositoryClass="App\Repository\EvenementRepository")
* @ORM\InheritanceType("SINGLE_TABLE")
* @ORM\DiscriminatorColumn(name="type", type="string")
* @ORM\DiscriminatorMap({
*     "evenement"="Evenement",
*     "tournoi"="Tournoi"
* })
*/
class Evenement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="text")
     */
    private $texte;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="datetime")
     */
    private $published_at;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Inscrit", mappedBy="evenement")
     */
    private $inscrits;

    /**
     * @ORM\Column(type="integer")
     */
    private $NbInscrits;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isTournoi;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Salle;

    public function __construct()
    {
        $this->inscrits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getTexte(): ?string
    {
        return $this->texte;
    }

    public function setTexte(string $texte): self
    {
        $this->texte = $texte;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->published_at;
    }

    public function setPublishedAt(\DateTimeInterface $published_at): self
    {
        $this->published_at = $published_at;

        return $this;
    }

    /**
     * @return Collection|Inscrit[]
     */
    public function getInscrits(): Collection
    {
        return $this->inscrits;
    }

    public function addInscrit(Inscrit $inscrit): self
    {
        if (!$this->inscrits->contains($inscrit)) {
            $this->inscrits[] = $inscrit;
            $inscrit->setEvenement($this);
        }

        return $this;
    }

    public function removeInscrit(Inscrit $inscrit): self
    {
        if ($this->inscrits->contains($inscrit)) {
            $this->inscrits->removeElement($inscrit);
            // set the owning side to null (unless already changed)
            if ($inscrit->getEvenement() === $this) {
                $inscrit->setEvenement(null);
            }
        }

        return $this;
    }

    public function getNbInscrits(): ?int
    {
        return $this->NbInscrits;
    }

    public function setNbInscrits(int $NbInscrits): self
    {
        $this->NbInscrits = $NbInscrits;

        return $this;
    }

    public function getIsTournoi(): ?bool
    {
        return $this->isTournoi;
    }

    public function setIsTournoi(bool $isTournoi): self
    {
        $this->isTournoi = $isTournoi;

        return $this;
    }

    public function getSalle(): ?string
    {
        return $this->Salle;
    }

    public function setSalle(string $Salle): self
    {
        $this->Salle = $Salle;

        return $this;
    }

  
}
