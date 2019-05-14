<?php

namespace App\Controller;

use App\Entity\BracketDirect;
use App\Form\BracketDirect1Type;
use App\Form\BracketDirectType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/bracket/direct")
 */
class BracketDirectController extends AbstractController
{
    /**
     * @Route("/", name="bracket_direct_index", methods={"GET"})
     */
    public function index(): Response
    {
        $bracketDirects = $this->getDoctrine()
            ->getRepository(BracketDirect::class)
            ->findAll();

        return $this->render('bracket_direct/index.html.twig', [
            'bracket_directs' => $bracketDirects,
        ]);
    }

    /**
     * @Route("/new", name="bracket_direct_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $bracketDirect = new BracketDirect();
        $form = $this->createForm(BracketDirect1Type::class, $bracketDirect);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bracketDirect);
            $entityManager->flush();

            return $this->redirectToRoute('bracket_direct_index');
        }

        return $this->render('bracket_direct/new.html.twig', [
            'bracket_direct' => $bracketDirect,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="bracket_direct_show", methods={"GET"})
     */
    public function show(BracketDirect $bracketDirect): Response
    {
        return $this->render('bracket_direct/show.html.twig', [
            'bracket_direct' => $bracketDirect,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="bracket_direct_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, BracketDirect $bracketDirect): Response
    {
        $form = $this->createForm(BracketDirectType::class, $bracketDirect);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('evenement_show', [
                'id' => $bracketDirect->getTournoi()->getId(),
            ]);
        }
        $inscrits = $bracketDirect->getTournoi()->getInscrits();
        return $this->render('bracket_direct/edit.html.twig', [
            'bracket_direct' => $bracketDirect,
            'nbTour' => $bracketDirect->nbTour(),
            'inscrits' => $inscrits,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="bracket_direct_delete", methods={"DELETE"})
     */
    public function delete(Request $request, BracketDirect $bracketDirect): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bracketDirect->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($bracketDirect);
            $entityManager->flush();
        }

        return $this->redirectToRoute('bracket_direct_index');
    }
}
