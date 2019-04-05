<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MatiereRepository")
 */
class Matiere
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
     * @ORM\ManyToOne(targetEntity="App\Entity\CategorieMatiere", inversedBy="matieres")
     */
    private $categorie;

    /**
     * @Gedmo\Slug(fields={"titre"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Archives", mappedBy="matiere")
     */
    private $archives;

    public function __construct()
    {
        $this->archives = new ArrayCollection();
    }

    public function getSlug()
    {
      return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
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

    public function getCategorie(): ?CategorieMatiere
    {
        return $this->categorie;
    }

    public function setCategorie(?CategorieMatiere $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection|Archives[]
     */
    public function getArchives(): Collection
    {
        return $this->archives;
    }

    public function addArchive(Archives $archive): self
    {
        if (!$this->archives->contains($archive)) {
            $this->archives[] = $archive;
            $archive->setMatiere($this);
        }

        return $this;
    }

    public function removeArchive(Archives $archive): self
    {
        if ($this->archives->contains($archive)) {
            $this->archives->removeElement($archive);
            // set the owning side to null (unless already changed)
            if ($archive->getMatiere() === $this) {
                $archive->setMatiere(null);
            }
        }

        return $this;
    }
}
