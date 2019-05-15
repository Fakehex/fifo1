<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Joueur;
use App\Entity\Equipe;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/evenement")
 */
class PageEvenementController extends AbstractController
{
    /**
     * @Route("/", name="evenements", methods={"GET"})
     */
    public function index(EvenementRepository $evenementRepository): Response
    {
        return $this->render('page_evenement/index.html.twig', [
            'evenements' => $evenementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="evenement", methods={"GET","POST"})
     */
    public function show(Evenement $evenement,Request $request, UserRepository $UserRepository): Response
    {
      $inscrits = $evenement->getInscrits();
      $connecte = $request->getSession()->get('co');
      $username = $request->getSession()->get('username');
      $estInscrit = false;
      if($connecte){
        $user = $UserRepository->findOneBy(['username' => $username]);
        $estInscrit = $user->estInscrit($evenement);
        if($evenement->getNbInscrits()>1 && !$estInscrit){

          $equipe = new Equipe();
          $equipe->setEvenement($evenement);

          $form = $this->createFormBuilder()
            ->add('nomEquipe')
            ->add('leader');
          for($i = 1; $i < $evenement->getNbInscrits(); $i++){
            $form->add('joueur'.$i);
          }
          $form = $form->getForm();

          $form->handleRequest($request);
          $entityManager = $this->getDoctrine()->getManager();

          if ($form->isSubmitted() && $form->isValid()) {
            // data is an array with "joueur1", "joueur2"..., and "leader" keys
            $data = $form->getData();
            $equipe->setNom($data['nomEquipe']);


            $joueur = new Joueur();
            $joueur->setNom($data['leader']);
            $joueur->setUser($user);
            $joueur->setEvenement($evenement);
            $joueur->setEquipe($equipe);
            $equipe->setLeader($joueur);

            for($i = 1; $i < $evenement->getNbInscrits(); $i++){
              $joueur = new Joueur();
              $joueur->setNom($data['joueur'.$i]);
              $joueur->setEvenement($evenement);
              $entityManager->persist($joueur);
              $equipe->addJoueur($joueur);

            }
            $entityManager->persist($equipe);
            $entityManager->flush();
          }
            $this->addFlash('success', 'Votre equipe est mainteant inscrit !');
          return $this->render('page_evenement/show.html.twig', [
              'evenement' => $evenement,
              'inscrits' => $inscrits,
              'connecte' => $connecte,
              'form' => $form->createView(),
              'estInscrit' => $estInscrit,
          ]);
        }
      }
        return $this->render('page_evenement/show.html.twig', [
            'evenement' => $evenement,
            'inscrits' => $inscrits,
            'connecte' => $connecte,
            'estInscrit' => $estInscrit,
        ]);
    }
    /**
     * @Route("/inscription/{id}", name="inscription", methods={"GET"})
     */
    public function inscription(Evenement $evenement, Request $request, UserRepository $UserRepository): Response
    {   $username = $request->getSession()->get('username');
        $user = $UserRepository->findOneBy(['username' => $username]);
        $inscrits = $evenement->getInscrits();
        $estInscrit = $user->estInscrit($evenement);

        $joueurs = $user->getJoueurs();
        foreach($joueurs as $joueur){
            if($joueur->getEvenement()->getId() == $evenement->getId()){
                $this->addFlash('danger', 'Vous etes deja inscrit a cet evenement');
                return $this->render('page_evenement/show.html.twig', [
                  'evenement' => $evenement,
                  'inscrits' => $inscrits,
                  'connecte' => true,
                  'estInscrit' => $estInscrit,
                ]);
            }
        }
        $joueur = new Joueur();
        $joueur->setNom($username);
        $joueur->setUser($user);
        $joueur->setEvenement($evenement);


        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($joueur);
        $entityManager->flush();


        $this->addFlash('success', 'Vous etes maintenant inscrit a cet evenement');
        return $this->render('page_evenement/show.html.twig', [
          'evenement' => $evenement,
          'inscrits' => $inscrits,
          'connecte' => true,
          'estInscrit' => $estInscrit,
        ]);
    }

    /**
     * @Route("/affiche_bracket/{id}", name="affiche_bracket", methods={"GET"})
     */
    public function affiche_bracket(Evenement $evenement){
       $bracketDirect = $evenement->getBracket();
       $duels = $bracketDirect->getDuels();
       $inscrits = $evenement->getInscrits();
       $nbTour = 0;
       foreach ($duels as $duel) {
         if($duel->getTour() > $nbTour){
           $nbTour = $duel->getTour();
         }
       }

      return $this->render('page_evenement/bracket.html.twig',[
        'evenement' => $evenement,
        'inscrits' => $inscrits,
        'nbTour' => $nbTour
      ]);
    }

}
