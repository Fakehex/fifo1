<?php

namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArchivesRepository")
 */
class Archives
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Veuillez importer le pdf de l'archive")
     * @Assert\File(mimeTypes={"application/pdf"})
     */
    private $sujet;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $secondeSession;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Correction", mappedBy="archive")
     */
    private $corrections;

    public function __construct()
    {
        $this->corrections = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSujet()
    {
        return $this->sujet;
    }

    public function setSujet(string $sujet)
    {
        $this->sujet = $sujet;

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

    public function getSecondeSession(): ?bool
    {
        return $this->secondeSession;
    }

    public function setSecondeSession(?bool $secondeSession): self
    {
        $this->secondeSession = $secondeSession;

        return $this;
    }

    /**
     * @return Collection|Correction[]
     */
    public function getCorrections(): Collection
    {
        return $this->corrections;
    }

    public function addCorrection(Correction $correction): self
    {
        if (!$this->corrections->contains($correction)) {
            $this->corrections[] = $correction;
            $correction->setArchive($this);
        }

        return $this;
    }

    public function removeCorrection(Correction $correction): self
    {
        if ($this->corrections->contains($correction)) {
            $this->corrections->removeElement($correction);
            // set the owning side to null (unless already changed)
            if ($correction->getArchive() === $this) {
                $correction->setArchive(null);
            }
        }

        return $this;
    }
}
