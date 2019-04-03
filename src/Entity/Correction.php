<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CorrectionRepository")
 */
class Correction
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
     * @Assert\NotBlank(message="Veuillez importer un pdf de la correction")
     * @Assert\File(mimeTypes={"application/pdf"})
     */
    private $correction;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="integer")
     */
    private $pocebleu;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Archives", inversedBy="corrections")
     * @ORM\JoinColumn(nullable=false)
     */
    private $archive;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCorrection(): ?string
    {
        return $this->correction;
    }

    public function setCorrection(string $correction): self
    {
        $this->correction = $correction;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPocebleu(): ?int
    {
        return $this->pocebleu;
    }

    public function setPocebleu(int $pocebleu): self
    {
        $this->pocebleu = $pocebleu;

        return $this;
    }

    public function getArchive(): ?Archives
    {
        return $this->archive;
    }

    public function setArchive(?Archives $archive): self
    {
        $this->archive = $archive;

        return $this;
    }
}
