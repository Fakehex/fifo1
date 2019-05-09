<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Tournoi;
use App\Entity\Duel;
use App\Entity\BracketDirect;
use App\Form\EvenementType;
use App\Form\TournoiType;
use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;


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
     * @Route("/affiche_bracket/{id}", name="affiche_bracket", methods={"GET"})
     */
    public function affiche_bracket(Evenement $evenement){
      $inscrits = $evenement->getInscrits();
      return $this->render('bracket.html.twig',[
        'evenement' => $evenement,
        'inscrits' => $inscrits
      ]);
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
       $bracketDirect = $evenement->getBracket();
       $inscrits = $evenement->getInscrits();
       $duels = $bracketDirect->getDuels();

       $tourPrecedent = $bracketDirect->getTourActuel();
       $bracketDirect->setTourActuel($tourPrecedent + 1);

       $gagnants;
       $i = 0;
       foreach ($duels as $duel) {
         if($duel->getTour() == $tourPrecedent){
           $gagnants[$i++] = $duel->getGagnant();
         }
       }

       $n = 0; //
       $nbGagnants = sizeof($gagnants);
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
       }

       $entityManager->persist($bracketDirect);
       $entityManager->flush();

       $this->addFlash('success', 'Le tournoi est au tour '. $bracketDirect->getTourActuel());
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
}
