<?php

namespace App\Controller;

use App\Entity\CategorieForum;
use App\Form\CategorieForumType;
use App\Repository\CategorieForumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/categorie_forum")
 */
class CategorieForumController extends AbstractController
{
    /**
     * @Route("/", name="categorie_forum_index", methods={"GET"})
     */
    public function index(CategorieForumRepository $categorieForumRepository): Response
    {
        return $this->render('categorie_forum/index.html.twig', [
            'categorie_forums' => $categorieForumRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="categorie_forum_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $categorieForum = new CategorieForum();
        $form = $this->createForm(CategorieForumType::class, $categorieForum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categorieForum);
            $entityManager->flush();

            return $this->redirectToRoute('categorie_forum_index');
        }

        return $this->render('categorie_forum/new.html.twig', [
            'categorie_forum' => $categorieForum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categorie_forum_show", methods={"GET"})
     */
    public function show(CategorieForum $categorieForum): Response
    {
        return $this->render('categorie_forum/show.html.twig', [
            'categorie_forum' => $categorieForum,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="categorie_forum_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CategorieForum $categorieForum): Response
    {
        $form = $this->createForm(CategorieForumType::class, $categorieForum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categorie_forum_index', [
                'id' => $categorieForum->getId(),
            ]);
        }

        return $this->render('categorie_forum/edit.html.twig', [
            'categorie_forum' => $categorieForum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categorie_forum_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CategorieForum $categorieForum): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorieForum->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($categorieForum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('categorie_forum_index');
    }
}
