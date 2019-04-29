<?php

namespace App\Controller;

use App\Entity\Duel;
use App\Form\DuelType;
use App\Repository\DuelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/duel")
 */
class DuelController extends AbstractController
{
    /**
     * @Route("/", name="duel_index", methods={"GET"})
     */
    public function index(DuelRepository $duelRepository): Response
    {
        return $this->render('duel/index.html.twig', [
            'duels' => $duelRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="duel_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $duel = new Duel();
        $form = $this->createForm(DuelType::class, $duel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($duel);
            $entityManager->flush();

            return $this->redirectToRoute('duel_index');
        }

        return $this->render('duel/new.html.twig', [
            'duel' => $duel,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="duel_show", methods={"GET"})
     */
    public function show(Duel $duel): Response
    {
        return $this->render('duel/show.html.twig', [
            'duel' => $duel,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="duel_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Duel $duel): Response
    {
        $form = $this->createForm(DuelType::class, $duel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('duel_index', [
                'id' => $duel->getId(),
            ]);
        }

        return $this->render('duel/edit.html.twig', [
            'duel' => $duel,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="duel_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Duel $duel): Response
    {
        if ($this->isCsrfTokenValid('delete'.$duel->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($duel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('duel_index');
    }
}
