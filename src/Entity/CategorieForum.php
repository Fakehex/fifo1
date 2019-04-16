<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
/**
 * @ORM\Entity(repositoryClass="App\Repository\CategorieForumRepository")
 */
class CategorieForum
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
     * @ORM\OneToMany(targetEntity="App\Entity\Topic", mappedBy="categorieForum")
     */
    private $topic;

    /**
     * @Gedmo\Slug(fields={"titre"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    public function getSlug()
    {
      return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function __construct()
    {
        $this->topic = new ArrayCollection();
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

    /**
     * @return Collection|Topic[]
     */
    public function getTopic(): Collection
    {
        return $this->topic;
    }

    public function addTopic(Topic $topic): self
    {
        if (!$this->topic->contains($topic)) {
            $this->topic[] = $topic;
            $topic->setCategorieForum($this);
        }

        return $this;
    }

    public function removeTopic(Topic $topic): self
    {
        if ($this->topic->contains($topic)) {
            $this->topic->removeElement($topic);
            // set the owning side to null (unless already changed)
            if ($topic->getCategorieForum() === $this) {
                $topic->setCategorieForum(null);
            }
        }

        return $this;
    }
}
