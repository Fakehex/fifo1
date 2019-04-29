<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

 /**
 * @ORM\Entity(repositoryClass="App\Repository\InscritRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     "inscrit"="Inscrit",
 *     "joueur"="Joueur",
 *     "equipe"="Equipe"
 * })
 */
class Inscrit
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
    private $nom;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Maison", inversedBy="inscrits")
     */
    private $maison;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Evenement", inversedBy="inscrits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $evenement;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Duel", mappedBy="inscrit1")
     */
    private $duels;

    public function __construct()
    {
        $this->duels = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getMaison(): ?Maison
    {
        return $this->maison;
    }

    public function setMaison(?Maison $maison): self
    {
        $this->maison = $maison;

        return $this;
    }

    public function getEvenement(): ?Evenement
    {
        return $this->evenement;
    }

    public function setEvenement(?Evenement $evenement): self
    {
        $this->evenement = $evenement;

        return $this;
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
            $duel->setInscrit1($this);
        }

        return $this;
    }

    public function removeDuel(Duel $duel): self
    {
        if ($this->duels->contains($duel)) {
            $this->duels->removeElement($duel);
            // set the owning side to null (unless already changed)
            if ($duel->getInscrit1() === $this) {
                $duel->setInscrit1(null);
            }
        }

        return $this;
    }
}