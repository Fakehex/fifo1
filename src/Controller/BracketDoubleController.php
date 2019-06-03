<?php

namespace App\Controller;

use App\Entity\BracketDouble;
use App\Form\BracketDoubleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/bracket/double")
 */
class BracketDoubleController extends AbstractController
{
    /**
     * @Route("/", name="bracket_double_index", methods={"GET"})
     */
    public function index(): Response
    {
        $bracketDoubles = $this->getDoctrine()
            ->getRepository(BracketDouble::class)
            ->findAll();

        return $this->render('bracket_double/index.html.twig', [
            'bracket_doubles' => $bracketDoubles,
        ]);
    }

    /**
     * @Route("/new", name="bracket_double_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $bracketDouble = new BracketDouble();
        $form = $this->createForm(BracketDoubleType::class, $bracketDouble);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bracketDouble);
            $entityManager->flush();

            return $this->redirectToRoute('bracket_double_index');
        }

        return $this->render('bracket_double/new.html.twig', [
            'bracket_double' => $bracketDouble,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="bracket_double_show", methods={"GET"})
     */
    public function show(BracketDouble $bracketDouble): Response
    {
        return $this->render('bracket_double/show.html.twig', [
            'bracket_double' => $bracketDouble,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="bracket_double_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, BracketDouble $bracketDouble): Response
    {
        $form = $this->createForm(BracketDoubleType::class, $bracketDouble);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('evenement_show', [
                'id' => $bracketDouble->getTournoi()->getId(),
            ]);
        }

        $inscrits = $bracketDouble->getTournoi()->getInscrits();
        return $this->render('bracket_double/edit.html.twig', [
            'bracket_double' => $bracketDouble,
            'inscrits' => $inscrits,
            'form' => $form->createView(),
            'nbTourLooser' =>$bracketDouble->nbTourPerdant(),
            'nbTour' => $bracketDouble->nbTour(),
        ]);
    }

    /**
     * @Route("/{id}", name="bracket_double_delete", methods={"DELETE"})
     */
    public function delete(Request $request, BracketDouble $bracketDouble): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bracketDouble->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($bracketDouble);
            $entityManager->flush();
        }

        return $this->redirectToRoute('bracket_double_index');
    }
}
