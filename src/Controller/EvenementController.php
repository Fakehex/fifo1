<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Tournoi;
use App\Entity\Duel;
use App\Entity\BracketDirect;
use App\Entity\BracketDouble;
use App\Form\EvenementType;
use App\Form\BracketDirectType;
use App\Form\TournoiType;
use App\Form\DuelType;
use App\Repository\EvenementRepository;
use App\Repository\DuelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Annotations\AnnotationReader;


/**
 * @Route("/admin/evenement")
 */
class EvenementController extends AbstractController
{
    /**
     * @Route("/", name="evenement_index", methods={"GET"})
     */
    public function index(EvenementRepository $evenementRepository): Response
    {
        return $this->render('evenement/index.html.twig', [
            'evenements' => $evenementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="evenement_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($evenement);
            $entityManager->flush();

            return $this->redirectToRoute('evenement_index');
        }

        return $this->render('evenement/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/newTournoi", name="tournoi_new", methods={"GET","POST"})
     */
    public function newTournoi(Request $request): Response
    {
        $evenement = new Tournoi();
        $form = $this->createForm(TournoiType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($evenement);
            $entityManager->flush();

            return $this->redirectToRoute('evenement_index');
        }

        return $this->render('evenement/newTournoi.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evenement_show", methods={"GET"})
     */
    public function show(Evenement $evenement): Response
    {
        $inscrits = $evenement->getInscrits();
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
            'inscrits' => $inscrits,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="evenement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Evenement $evenement): Response
    {
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('evenement_index', [
                'id' => $evenement->getId(),
            ]);
        }

        return $this->render('evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evenement_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Evenement $evenement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evenement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($evenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('evenement_index');
    }


    /**
     * @Route("/initialiserBracketDirect/{id}", name="initialiserBracketDirect", methods={"GET"})
     */
    public function constructBracketDirect2(Evenement $evenement){
      $bracketDirect = new BracketDirect();
      $bracketDirect->setTourActuel(1);
      $inscrits = $evenement->getInscrits();
      $nbInscrits = sizeof($inscrits);
      $entityManager = $this->getDoctrine()->getManager();
      $numTour = 1;
      // Y c'est la puissance de 2 inferieur (au nombre d'inscrits)
      //et X est le nombre de participants supplementaire pour correspondre a notre nombre d'inscrits
      $y = 2;
      while($y < ($nbInscrits/2)){
        $y = $y*2;
      }
      $x = $nbInscrits - $y;

      $n = 0; // N est le numero de du prochain joueur a inscrire

      // LE PREMIER TOUR -> INITIALISATION
      for($i=0 ; $i < $x ; ++$i){
        $duel = new Duel();
        $duel->setInscrit1($inscrits[$n++]);
        $duel->setInscrit2($inscrits[$n++]);
        $duel->setTour($numTour);
        $duel->initScore();

        $entityManager->persist($duel);
        $bracketDirect->addDuel($duel);
      }

      $numTour++;
      // LE TOUR NUMERO 2 -> INITIALISATION
      $tour2;
      for($i=0 ; $i < $y/2 ; $i++){
        $duel = new Duel();
        $duel->setTour($numTour);
        $duel->initScore();

        $tour2[$i]= $duel;
      }
      //Remplir le tour 2
      $secondeBoucle = false;
      while($n < $nbInscrits) {
        $i=0;
        while(($n < $nbInscrits) && ($i < $y/2)){
            $duel = $tour2[$i];
            if($secondeBoucle){
              $duel->setInscrit2($inscrits[$n++]);
            }else{
              $duel->setInscrit1($inscrits[$n++]);
            }
            $tour2[$i]= $duel;
            $i++;
        }
        $secondeBoucle = true;
      }
      //ajout des duels tour2 dans le bracket
      foreach($tour2 as $duel){
        $entityManager->persist($duel);
        $bracketDirect->addDuel($duel);
      }
      //generer tout les autres tours :
      $y=$y/2;
      while($y >= 2){
        $y /= 2;
        $numTour++;
        for($i = 0; $i < $y; ++$i){
          $duel = new Duel();
          $duel->setTour($numTour);
          $duel->initScore();
          $entityManager->persist($duel);
          $bracketDirect->addDuel($duel);
        }
      }

      $evenement->setBracket($bracketDirect);
      $entityManager->persist($evenement);
      $entityManager->persist($bracketDirect);
      $entityManager->flush();

      $this->addFlash('success', 'voila Y : '.$y);

      return $this->render('evenement/show.html.twig', [
          'evenement' => $evenement,
          'inscrits' => $inscrits,
      ]);

    }


    /**
     * @Route("/tourSuivantBracketDirect/{id}", name="tourSuivantBracketDirect", methods={"GET"})
     */
     public function tourSuivantBracketDirect(Evenement $evenement){
         $entityManager = $this->getDoctrine()->getManager();
         $bracket = $evenement->getBracket();
         $inscrits = $evenement->getInscrits();
         $duels = $bracket->getDuels();


         $tourPrecedent = $bracket->getTourActuel();
         $bracket->setTourActuel($tourPrecedent + 1);

         if($bracket->getType() == "double"){
             $duelsP = $bracket->getDuelsPerdants();
             $tourPerdant = $bracket->getTourPerdant();
             $perdants = array();
             var_dump("oui");
         }


         $i = 0;
         $gagnants = array();
         foreach ($duels as $duel) {
             if($duel->getTour() == $tourPrecedent){
                 $gagnant = $duel->getGagnant();
                 if($gagnant != null){
                     $gagnants[$i++] = $gagnant;
                     if($bracket->getType() == "double"){
                         $perdants[$i++] = $duel->getPerdant();
                     }

                 }
             }
         }

         $n = 0; //
         $nbGagnants = count($gagnants);
         foreach ($duels as $duel) {
             if($duel->getTour() == $tourPrecedent + 1 ){
                 if($duel->getInscrit1() == null){
                     if($n < $nbGagnants){
                         $duel->setInscrit1($gagnants[$n++]);
                         $entityManager->persist($duel);
                     }else{
                         $this->addFlash('danger', 'Pas assez de gagnants pour remplir le prochain tour');
                         return $this->render('evenement/show.html.twig', [
                             'evenement' => $evenement,
                             'inscrits' => $inscrits,
                         ]);
                     }
                 }
                 if($duel->getInscrit2() == null){
                     if($n < $nbGagnants){
                         $duel->setInscrit2($gagnants[$n++]);
                         $entityManager->persist($duel);
                     }else{
                         $this->addFlash('danger', 'Pas assez de gagnants pour remplir le prochain tour');
                         return $this->render('evenement/show.html.twig', [
                             'evenement' => $evenement,
                             'inscrits' => $inscrits,
                         ]);
                     }
                 }
             }
         }

         $n = 0;
         if($bracket->getType() == "double"){
             foreach($duelsP as $duelP) {
                 if($duelP->getTour() == $tourPerdant){
                     if($duelP->getInscrit1() == null){
                         if($n < $nbGagnants){
                             $duel->setInscrit1($perdants[$n++]);
                             $entityManager->persist($duel);
                         }else{
                             $this->addFlash('danger', 'Pas assez de perdants pour remplir le prochain tour');
                             return $this->render('evenement/show.html.twig', [
                                 'evenement' => $evenement,
                                 'inscrits' => $inscrits,
                                 //n'arrive normalement jamais
                             ]);
                         }
                     }
                     if($duel->getInscrit2() == null){
                         if($n < $nbGagnants){
                             $duel->setInscrit2($perdants[$n++]);
                             $entityManager->persist($duel);
                         }else{
                             $this->addFlash('danger', 'Pas assez de perdants pour remplir le prochain tour');
                             return $this->render('evenement/show.html.twig', [
                                 'evenement' => $evenement,
                                 'inscrits' => $inscrits,
                             ]);
                         }
                     }else{
                         if(($duelP->getTour() == $tourPerdant+1) && ($tourPerdant == 1)){
                             if($duelP->getInscrit1() == null){
                                 if($n < $nbGagnants){
                                     $duel->setInscrit1($perdants[$n++]);
                                     $entityManager->persist($duel);
                                 }else{
                                     $this->addFlash('danger', 'Pas assez de perdants pour remplir le prochain tour');
                                     return $this->render('evenement/show.html.twig', [
                                         'evenement' => $evenement,
                                         'inscrits' => $inscrits,
                                         //n'arrive normalement jamais
                                     ]);
                                 }
                             }
                         }
                     }
                 }

             }
         }


         $entityManager->persist($bracket);
         $entityManager->flush();

         $this->addFlash('success', 'Le tournoi est au tour '. $bracket->getTourActuel());
         return $this->render('evenement/show.html.twig', [
             'evenement' => $evenement,
             'inscrits' => $inscrits,
         ]);


     }
    /*  public function tourSuivantBracketDirect(Evenement $evenement){

        $entityManager = $this->getDoctrine()->getManager();

        $bracket = $evenement->getBracket();
        $inscrits = $evenement->getInscrits();
        $duels = $bracket->getDuels();
        $duel = new Duel();
        // gerer les TOURS ICI ( verifier a quel tour on est pour utiliser les duels du dernier tour seulement )
        // ajouter tour actuel dans bracket
        $tourPrecedent = $bracketDirect->getTourActuel();
        $bracketDirect->setTourActuel($tourPrecedent + 1);

        $gagnants = new Array();
        foreach ($duels as $duel) {
          if($duel->getTour() == $tourPrecedent){
            $gagnants->add($duel->getGagnant());
          }
        }

        for($i = 0; $i < sizeof($gagnants) ; $i = $i+1) {
          $duel = new Duel();
          $duel->setInscrit1($gagnants[$i];
          if(sizeof($gagnants) < $i+1 ){
            $i = $i+1;
            $duel->setInscrit2($gagnants[$i]);
          }
          $duel->setTour();
          $duel->setScoreInscrit1(0);
          $duel->setScoreInscrit2(0);

          $entityManager->persist($duel);
          $bracket->addDuel($duel);
        }
        $entityManager->persist($bracket);
        $entityManager->flush();

        $this->addFlash('success', 'Le tournoi est au tour '. $bracketDirect->getTour());
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
            'inscrits' => $inscrits,
        ]);
      }*/

    /**
     * @Route("/initialiserBracketDouble/{id}", name="initialiserBracketDouble", methods={"GET"})
     */
    public function constructBracketDouble(Evenement $evenement)
    {
        //Le winner bracket est identique au bracket simple jusqu'a la finale
        $bracketDouble = new BracketDouble();
        $bracketDouble->setTourActuel(1);
        $inscrits = $evenement->getInscrits();
        $nbInscrits = sizeof($inscrits);
        $entityManager = $this->getDoctrine()->getManager();
        $numTour = 1;
        // Y c'est la puissance de 2 inferieur (au nombre d'inscrits)
        //et X est le nombre de participants supplementaire pour correspondre a notre nombre d'inscrits
        $y = 2;
        while ($y < ($nbInscrits / 2)) {
            $y = $y * 2;
        }
        $x = $nbInscrits - $y;
        /* Le looser bracket revient a creer un tournoi pour un nombre de participants égal au nombre de matchs joués au T1 et T2 du winner bracket
        La priorité au T1 du looser bracket est ceux qui n'ont pas joués d ematchs au T1 du winner bracket
        x matchs au T1 du looser bracket également
        */
        $n = 0; // N est le numero de du prochain joueur a inscrire

        // LE PREMIER TOUR -> INITIALISATION
        for($i=0 ; $i < $x ; ++$i){
            $duel = new Duel();
            $duel->setInscrit1($inscrits[$n++]);
            $duel->setInscrit2($inscrits[$n++]);
            $duel->setTour($numTour);
            $duel->initScore();

            $entityManager->persist($duel);
            $bracketDouble->addDuel($duel);
        }

        $y/=2;

        $numTour++;
        // LE TOUR NUMERO 2 -> INITIALISATION
        $tour2;
        for($i=0 ; $i < $y ; $i++){
            $duel = new Duel();
            $duel->setTour($numTour);
            $duel->initScore();

            $tour2[$i]= $duel;
        }
        //Remplir le tour 2
        $secondeBoucle = false;
        while($n < $nbInscrits) {
            $i=0;
            while(($n < $nbInscrits) && ($i < $y)){
                $duel = $tour2[$i];
                if($secondeBoucle){
                    $duel->setInscrit2($inscrits[$n++]);
                }else{
                    $duel->setInscrit1($inscrits[$n++]);
                }
                $tour2[$i]= $duel;
                $i++;
            }
            $secondeBoucle = true;
        }
        //ajout des duels tour2 dans le bracket
        foreach($tour2 as $duel){
            $entityManager->persist($duel);
            $bracketDouble->addDuel($duel);
        }

        //Gestion bracket perdant

        //T1 Loser Bracket

        $numTourPerdant = 1;

        $o = 2;
        while($o < ($bracketDouble->getnbDuelsTour(1, $bracketDouble->getDuels())+ $bracketDouble->getnbDuelsTour(2, $bracketDouble->getDuels()))/2){
            $o = $o*2;
        }
        $v = ($bracketDouble->getnbDuelsTour(1, $bracketDouble->getDuels())+ $bracketDouble->getnbDuelsTour(2, $bracketDouble->getDuels())) - $o;

        // LE PREMIER TOUR DES PERDANTS -> INITIALISATION
        for($i=0 ; $i < $v ; ++$i){
            $duel = new Duel();
            $duel->setTour($numTourPerdant);
            $duel->initScore();

            $entityManager->persist($duel);
            $bracketDouble->addDuelsPerdant($duel);
        }

        $numTourPerdant++;
        // LE TOUR NUMERO 2 DES PERDANTS-> INITIALISATION
        $tour2P;
        for($i=0 ; $i < $o/2 ; $i++){
            $duel = new Duel();
            $duel->setTour($numTourPerdant);
            $duel->initScore();

            $tour2P[$i]= $duel;
        }
        $secondeBoucle = false;
        while($n < $nbInscrits) {
            $i=0;
            while(($n < $nbInscrits) && ($i < $o/2)){
                $duel = $tour2P[$i];
                if($secondeBoucle){
                    $duel->setInscrit2($inscrits[$n++]);
                }else{
                    $duel->setInscrit1($inscrits[$n++]);
                }
                $tour2P[$i]= $duel;
                $i++;
            }
            $secondeBoucle = true;
        }
        //ajout des duels tour2 des perdants dans le bracket
        foreach($tour2P as $duel){
            $entityManager->persist($duel);
            $bracketDouble->addDuelsPerdant($duel);
        }


        /*Tous les autres tours
        Regles:
            On traite le Winner Bracket en premier pour générer le deuxieme
            T1 et T2 sont deja générés pour chaque Bracket
            Si nbMatch(Tour Actuel) = nbMatch(Tour Perdant Actuel) et nbMatch != 1: alors il y aura autant de matchs dans le tour perdant que de ce tour
            Si nbMatch(Tour Actuel) < nbMatch(Tour Perdant Actuel): il y a match entre les joueurs du loser bracket puis on traite a nouveau
            Si nbMatch(Tour Actuel) = nbMatch(Tour Perdant Actuel), nbMatch == 1 et nb Match(Tour Perdant Precedant) != 1: Finale des perdants
            Si nbMatch(Tour Actuel) = nbMatch(Tour Perdant Actuel), nbMatch == 1 et nb Match(Tour Perdant Precedant) == 1: Finale des gagnants
        La génération des 2 matchs supplémentaires ce fait dans TourSuivantDouble pour ajuster le nomrbe de matchs
        numTourPerdant = 2
        numTourActuel = 2

*/
        //generer tout les autres tours:

        /*while($y >= 2){
            $y /= 2;
            $numTour++;
            for($i = 0; $i < $y; ++$i){
                if() {
                    $duel = new Duel();
                    $duel->setTour($numTour);
                    $duel->initScore();
                    $entityManager->persist($duel);
                    $bracketDouble->addDuel($duel);

                }*/
        $finTournoi = false;

        while($finTournoi == false){

            //Si nbMatch(Tour Actuel) = nbMatch(Tour Perdant Actuel) et nbMatch != 1: alors il y aura autant de matchs dans le tour perdant que de ce tour
            $nbDuelsDernierTourPerdant = $bracketDouble->getnbDuelsTour($numTourPerdant, $bracketDouble->getDuelsPerdants());

            if(($y/2 == $nbDuelsDernierTourPerdant) && ($y/2 != 1) )
            {
                $y/=2;
                $numTour++;
                for($i = 0; $i < $y; ++$i){
                    $duel = new Duel();
                    $duel->setTour($numTour);
                    $duel->initScore();
                    $entityManager->persist($duel);
                    $bracketDouble->addDuel($duel);
                }

                $numTourPerdant++;
                for($i = 0; $i < $nbDuelsDernierTourPerdant; ++$i){
                    $duel = new Duel();
                    $duel->setTour($numTourPerdant);
                    $duel->initScore();
                    $entityManager->persist($duel);
                    $bracketDouble->addDuelsPerdant($duel);

                }


            }else{

                //Si nbMatch(Tour Actuel) = nbMatch(Tour Perdant Actuel), nbMatch == 1 et nb Match(Tour Perdant Precedant) != 1: Finale des perdants
                if(($y == $nbDuelsDernierTourPerdant) && ($bracketDouble->getnbDuelsTour($numTourPerdant-1, $bracketDouble->getDuelsPerdants()) != 1) )
                {
                    //Finale des perdants
                    $numTourPerdant++;
                    $duel = new Duel();
                    $duel->setTour($numTourPerdant);
                    $duel->initScore();
                    $entityManager->persist($duel);
                    $bracketDouble->addDuelsPerdant($duel);

                    //Finale des gagnants
                    $numTour++;
                    $duel = new Duel();
                    $duel->setTour($numTour);
                    $duel->initScore();
                    $entityManager->persist($duel);
                    $bracketDouble->addDuel($duel);

                    //Dernier Match des perdants
                    $numTourPerdant++;
                    $duel = new Duel();
                    $duel->setTour($numTourPerdant);
                    $duel->initScore();
                    $entityManager->persist($duel);
                    $bracketDouble->addDuelsPerdant($duel);

                    //Grande Finale
                    $numTour++;
                    $duel = new Duel();
                    $duel->setTour($numTour);
                    $duel->initScore();
                    $entityManager->persist($duel);
                    $bracketDouble->addDuel($duel);
                    $finTournoi = true;
                    $finTournoi = true;
                }
                else{
                    //Si nbMatch(Tour Actuel) < nbMatch(Tour Perdant Actuel): il y a match entre les joueurs du loser bracket puis on traite a nouveau
                    if($y < $nbDuelsDernierTourPerdant) {
                        $numTourPerdant++;
                        for ($i = 0; $i < ($bracketDouble->getnbDuelsTour($numTourPerdant - 1, $bracketDouble->getDuelsPerdants()) / 2); ++$i) {
                            $duel = new Duel();
                            $duel->setTour($numTourPerdant);
                            $duel->initScore();
                            $entityManager->persist($duel);
                            $bracketDouble->addDuelsPerdant($duel);
                        }
                    }else{
                        $y/=2;
                        $numTour++;
                        for($i = 0; $i < $y; ++$i){
                            $duel = new Duel();
                            $duel->setTour($numTour);
                            $duel->initScore();
                            $entityManager->persist($duel);
                            $bracketDouble->addDuel($duel);
                        }

                        $numTourPerdant++;
                        for($i = 0; $i < $nbDuelsDernierTourPerdant; ++$i){
                            $duel = new Duel();
                            $duel->setTour($numTourPerdant);
                            $duel->initScore();
                            $entityManager->persist($duel);
                            $bracketDouble->addDuelsPerdant($duel);

                            $y/=2;
                        }
                    }
                }
            }

        }


        $evenement->setBracket($bracketDouble);
        $entityManager->persist($evenement);
        $entityManager->persist($bracketDouble);
        $entityManager->flush();

        $this->addFlash('success', 'voila Y : '.$y);

        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
            'inscrits' => $inscrits,
        ]);


    }


    /**
     * @Route("/tourSuivantBracketDoubleW/{id}", name="tourSuivantBracketDoubleW", methods={"GET"})
     */
    public function tourSuivantBracketDoubleW(Evenement $evenement){





    }


    /*
         * Regles du tour suivant:
         * 1°) Jouer les T1 et T2 du winner Bracket
         * Les gagnants sont sauvegardés et passent au tour suivant
         * Les perdants sont sauvegardés et permetent de remplir le T1 et T2 du loser Bracket
         *
         * 2°) Jouer le T1 du loser Bracket
         *
         * 3°) SI nbMatchTourSuivant < nbMatchPerdants
         *      -La partie du loser bracket est jouée
         *     Sinon: Remplir tourSuivant winner avec les gagnants
         *              -Remplir matchs(1/2) loser avec les perdants et les gagnants du tour precedant
         * 4°) Derneir match Loser
         * Le gagnant loser retourne dans le winner bracket (il faut un moyen de le reconnaitre)
         *
         * 5°)Dernier Match (sauf cas d'un match supplémentaire)
         * Si le loser perd: fin
         * Si le gagnant perd: Création d'un ultime match
         *
         *
         */

    /*
     * Si simple: effectuer le tour suivant classique.
     * Si c'est un double, effectuer le tour classique et ajouter les perdants au bon endroit (?)
     * Si c'est le dernier match du winner bracket et que le perdant a gagné, creer un nouveau match qui sera dans tous les cas le dernier
     * Faire un bouton Winner et Loser Bracket ? (Et vérifier que le loser bracket est valide ?)
     *
     *Il faut récupérer le type de l'événement
     *
     */



}
