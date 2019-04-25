<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Joueur;
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
     * @Route("/{id}", name="evenement", methods={"GET"})
     */
    public function show(Evenement $evenement): Response
    {
        $inscrits = $evenement->getInscrits();
        return $this->render('page_evenement/show.html.twig', [
            'evenement' => $evenement,
            'inscrits' => $inscrits,
        ]);
    }
    /**
     * @Route("/inscription/{id}", name="inscription", methods={"GET"})
     */
    public function inscription(Evenement $evenement,EvenementRepository $evenementRepository, Request $request, UserRepository $UserRepository): Response
    {   $username = $request->getSession()->get('username');
        $user = $UserRepository->findOneBy(['username' => $username]);
        $joueur = new Joueur();
        $joueur->setNom($username);
        $joueur->setUser($user);
        $joueur->setEvenement($evenement);


        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($joueur);
        $entityManager->flush();


        $inscrits = $evenement->getInscrits();
        return $this->render('page_evenement/show.html.twig', [
          'evenement' => $evenement,
          'inscrits' => $inscrits,
        ]);
    }

}
