<?php

namespace App\Controller;

use App\Entity\CategorieMatiere;
use App\Form\CategorieMatiereType;
use App\Repository\CategorieMatiereRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/categorie_matiere")
 */
class CategorieMatiereController extends AbstractController
{
    /**
     * @Route("/", name="categorie_matiere_index", methods={"GET"})
     */
    public function index(CategorieMatiereRepository $categorieMatiereRepository): Response
    {
        return $this->render('categorie_matiere/index.html.twig', [
            'categorie_matieres' => $categorieMatiereRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="categorie_matiere_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $categorieMatiere = new CategorieMatiere();
        $form = $this->createForm(CategorieMatiereType::class, $categorieMatiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categorieMatiere);
            $entityManager->flush();

            return $this->redirectToRoute('categorie_matiere_index');
        }

        return $this->render('categorie_matiere/new.html.twig', [
            'categorie_matiere' => $categorieMatiere,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categorie_matiere_show", methods={"GET"})
     */
    public function show(CategorieMatiere $categorieMatiere): Response
    {
        return $this->render('categorie_matiere/show.html.twig', [
            'categorie_matiere' => $categorieMatiere,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="categorie_matiere_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CategorieMatiere $categorieMatiere): Response
    {
        $form = $this->createForm(CategorieMatiereType::class, $categorieMatiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categorie_matiere_index', [
                'id' => $categorieMatiere->getId(),
            ]);
        }

        return $this->render('categorie_matiere/edit.html.twig', [
            'categorie_matiere' => $categorieMatiere,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categorie_matiere_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CategorieMatiere $categorieMatiere): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorieMatiere->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($categorieMatiere);
            $entityManager->flush();
        }

        return $this->redirectToRoute('categorie_matiere_index');
    }
}
