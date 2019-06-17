<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Inscrit;

/**
 * @ORM\Entity
 */
class Joueur extends Inscrit
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="joueurs")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Equipe", inversedBy="Joueurs",cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $equipe;


    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getEquipe(): ?Equipe
    {
        return $this->equipe;
    }

    public function setEquipe(?Equipe $equipe): self
    {
        $this->equipe = $equipe;

        return $this;
    }
}
