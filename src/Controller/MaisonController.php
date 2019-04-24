<?php

namespace App\Controller;

use App\Entity\Maison;
use App\Form\MaisonType;
use App\Repository\MaisonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/maison")
 */
class MaisonController extends AbstractController
{
    /**
     * @Route("/", name="maison_index", methods={"GET"})
     */
    public function index(MaisonRepository $maisonRepository): Response
    {
        return $this->render('maison/index.html.twig', [
            'maisons' => $maisonRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="maison_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $maison = new Maison();
        $form = $this->createForm(MaisonType::class, $maison);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($maison);
            $entityManager->flush();

            return $this->redirectToRoute('maison_index');
        }

        return $this->render('maison/new.html.twig', [
            'maison' => $maison,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="maison_show", methods={"GET"})
     */
    public function show(Maison $maison): Response
    {
        return $this->render('maison/show.html.twig', [
            'maison' => $maison,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="maison_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Maison $maison): Response
    {
        $form = $this->createForm(MaisonType::class, $maison);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('maison_index', [
                'id' => $maison->getId(),
            ]);
        }

        return $this->render('maison/edit.html.twig', [
            'maison' => $maison,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="maison_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Maison $maison): Response
    {
        if ($this->isCsrfTokenValid('delete'.$maison->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($maison);
            $entityManager->flush();
        }

        return $this->redirectToRoute('maison_index');
    }
}
