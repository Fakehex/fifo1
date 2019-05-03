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
    public function constructBracketDirect(Evenement $evenement){
      $bracketDirect = new BracketDirect();
      $inscrits = $evenement->getInscrits();
      $entityManager = $this->getDoctrine()->getManager();

      for($i = 0; $i < sizeof($inscrits); $i = $i+2){
          $duel = new Duel();
          $duel->setInscrit1($inscrits[$i]);
          $duel->setInscrit2($inscrits[$i+1]);
          $duel->setTour(1);
          $duel->setScoreInscrit1(0);
          $duel->setScoreInscrit2(0);

          $entityManager->persist($duel);
          $bracketDirect->addDuel($duel);
      }
      $evenement->setBracket($bracketDirect);
      $entityManager->persist($evenement);
      $entityManager->persist($bracketDirect);
      $entityManager->flush();

      $this->addFlash('success', 'Initialisation du tournoi terminé');

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
        $duel = new Duel();
        // gerer les TOURS ICI ( verifier a quel tour on est pour utiliser les duels du dernier tour seulement )
        // ajouter tour actuel dans bracket
        for($i = 0; $i < sizeof($duels) ; $i = $i+2) {
          $duel = new Duel();
          $duel->setInscrit1($duels[0]->getGagnant());
          $duel->setInscrit2($duels[1]->getGagnant());
          $duel->setTour($duels[1]->getTour() + 1 );
          $duel->setScoreInscrit1(0);
          $duel->setScoreInscrit2(0);

          $entityManager->persist($duel);
          $bracket->addDuel($duel);
        }
        $entityManager->persist($bracket);
        $entityManager->flush();

        $this->addFlash('success', 'Le tournoi est au tour '. $duel->getTour());
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
            'inscrits' => $inscrits,
        ]);
      }
}
