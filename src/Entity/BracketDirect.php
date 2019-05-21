<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Bracket;
use App\Entity\Duel;

/**
 * @ORM\Entity
 */
class BracketDirect extends Bracket
{
  public function nbTour(){
    $nbTour = 0;
    foreach ($this->duels as $duel) {
      if($duel->getTour() > $nbTour){
        $nbTour = $duel->getTour();
      }
    }
    return $nbTour;
  }

  public function getType(): ?string
  {
      return "direct";
  }
}
