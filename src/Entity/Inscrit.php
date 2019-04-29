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
     * @ORM\OneToMany(targetEntity="App\Entity\Match", mappedBy="inscrit1")
     */
    private $matches;

    public function __construct()
    {
        $this->matches = new ArrayCollection();
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
     * @return Collection|Match[]
     */
    public function getMatches(): Collection
    {
        return $this->matches;
    }

    public function addMatch(Match $match): self
    {
        if (!$this->matches->contains($match)) {
            $this->matches[] = $match;
            $match->setInscrit1($this);
        }

        return $this;
    }

    public function removeMatch(Match $match): self
    {
        if ($this->matches->contains($match)) {
            $this->matches->removeElement($match);
            // set the owning side to null (unless already changed)
            if ($match->getInscrit1() === $this) {
                $match->setInscrit1(null);
            }
        }

        return $this;
    }
}
