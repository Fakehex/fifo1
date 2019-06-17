<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Joueur;
use App\Entity\Equipe;
use App\Form\EvenementType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Repository\EvenementRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
/**
 * @Route("/evenement")
 */
class PageEvenementController extends AbstractController
{
    /**
     * @Route("/", name="evenements", methods={"GET","POST"})
     */
    public function index(EvenementRepository $evenementRepository, Request $request, UserRepository $UserRepository, PaginatorInterface $paginator): Response
    {
      $estConnecte = $request->getSession()->get('co');
      $username = $request->getSession()->get('username');
      $estInscrit = array();
      $formEquipes = array();
      $allEvenements = $evenementRepository->findAllSortedDate();
      if($estConnecte){
        $user = $UserRepository->findOneBy(['username' => $username]);

        foreach($allEvenements as $evenement){
            $estInscrit[$evenement->getId()] = $user->estInscrit($evenement);

            //Formulaire pour les equipes --------------
            if($evenement->getNbInscrits()>1 && !$estInscrit[$evenement->getId()]){
              $equipe = new Equipe();
              $equipe->setEvenement($evenement);

              $formEquipe = $this->createFormBuilder()
                ->add('nomEquipe',TextType::class,['attr'=>['class'=>'form-control','placeholder'=>"Nom d'équipe"]])
                ->add('leader',TextType::class,['attr'=>['class'=>'form-control','placeholder'=>"Capitaine"]]);
              for($i = 1; $i < $evenement->getNbInscrits(); $i++){
                $formEquipe->add('joueur'.$i,TextType::class,['attr'=>['class'=>'form-control','placeholder'=>"Coéquipier ".$i]]);
              }
              $formEquipe->add('submit',SubmitType::class,['label' =>'Enregistrer','attr'=>['class'=>'btnSecondary btn-dark']]);
              $formEquipe = $formEquipe->getForm();

              $formEquipe->handleRequest($request);
              $entityManager = $this->getDoctrine()->getManager();

              if ($formEquipe->isSubmitted() && $formEquipe->isValid()) {
                // data is an array with "joueur1", "joueur2"..., and "leader" keys
                $data = $formEquipe->getData();
                $equipe->setNom($data['nomEquipe']);

                $joueur = new Joueur();
                $joueur->setNom($data['leader']);
                $joueur->setUser($user);
                $joueur->setEvenement($evenement);
                $joueur->setEquipe($equipe);
                $equipe->setLeader($joueur);
                for($i = 1; $i < sizeof($data)-1; $i++){
                  $joueur = new Joueur();
                  $joueur->setNom($data['joueur'.$i]);
                  $joueur->setEvenement($evenement);
                  $entityManager->persist($joueur);
                  $equipe->addJoueur($joueur);

                }
                $entityManager->persist($equipe);
                $entityManager->flush();

                $this->addFlash('success', 'Votre equipe est mainteant inscrite !');
                return $this->redirectToRoute('evenements');
            }
            $formEquipes[$evenement->getId()] = $formEquipe->createView();
        }
      }
    }
      // Paginate the results of the query
        $evenements = $paginator->paginate(
            // Doctrine Query, not results
            $allEvenements,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            5
        );

        return $this->render('page_evenement/index.html.twig', [
            'evenements' => $evenements,
            'estConnecte'=> $estConnecte,
            'estInscrit'=> $estInscrit,
            'formEquipes'=> $formEquipes,
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
          return $this->render('page_evenement/index.html.twig', [
              'evenement' => $evenement,
              'inscrits' => $inscrits,
              'connecte' => $connecte,
              'form' => $form->createView(),
              'estInscrit' => $estInscrit,
          ]);
        }
      }

        return $this->render('page_evenement/inscription_equipe.html.twig', [
            'evenement' => $evenement,
            'inscrits' => $inscrits,
            'connecte' => $connecte,
            'estInscrit' => $estInscrit,
        ]);
    }
    /**
     * @Route("/inscription_equipe/{id}", name="inscription_equipe", methods={"GET","POST"})
     */
    public function inscription_equipe(Evenement $evenement,Request $request, UserRepository $UserRepository): Response
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

            $this->addFlash('success', 'Votre equipe est mainteant inscrit !');
            return $this->redirectToRoute('evenements');
          }

          return $this->render('page_evenement/inscription_equipe.html.twig', [
              'form' => $form->createView(),
              'evenement' => $evenement,
              'inscrits' => $inscrits,
              'connecte' => $connecte,
              'estInscrit' => $estInscrit,
          ]);
        }
      }

        $this->addFlash('danger', 'Redirection : cette page vous est inaccessible');
        return $this->redirectToRoute('evenements');
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
       $bracket = $evenement->getBracket();
       $inscrits = $evenement->getInscrits();

       $nbTour = $bracket->nbTour();

       if($bracket->getType() == "double") {
            $nbTourPerdant = $bracket->nbTourPerdant();

           return $this->render('page_evenement/bracket_double.html.twig',[
               'evenement' => $evenement,
               'inscrits' => $inscrits,
               'nbTour' => $nbTour,
               'nbTourLooser' => $nbTourPerdant,

           ]);
       }

      return $this->render('page_evenement/bracket.html.twig',[
        'evenement' => $evenement,
        'inscrits' => $inscrits,
        'nbTour' => $nbTour,
          ]);
    }

}
