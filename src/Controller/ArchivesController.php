<?php

namespace App\Controller;

use App\Entity\Archives;
use App\Form\ArchivesType;
use App\Repository\ArchivesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\FileUploader;

/**
 * @Route("/admin/archives")
 */
class ArchivesController extends AbstractController
{
    /**
     * @Route("/", name="archives_index", methods={"GET"})
     */
    public function index(ArchivesRepository $archivesRepository): Response
    {
        return $this->render('archives/index.html.twig', [
            'archives' => $archivesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="archives_new", methods={"GET","POST"})
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $archive = new Archives();
        $form = $this->createForm(ArchivesType::class, $archive);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $archive->getSujet();
            $fileName = $fileUploader->upload($file);

            $archive->setSujet($fileName);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($archive);
            $entityManager->flush();

            return $this->redirectToRoute('archives_index');
        }

        return $this->render('archives/new.html.twig', [
            'archive' => $archive,
            'form' => $form->createView(),
        ]);
    }
    private function generationUniqueFileName(){
      return md5(uniqid());
    }

    /**
     * @Route("/{id}", name="archives_show", methods={"GET"})
     */
    public function show(Archives $archive): Response
    {
        return $this->render('archives/show.html.twig', [
            'archive' => $archive,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="archives_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Archives $archive,FileUploader $fileUploader): Response
    {
        $form = $this->createForm(ArchivesType::class, $archive);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $archive->getSujet();
            $fileName = $fileUploader->upload($file);

            $archive->setSujet($fileName);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('archives_index', [
                'id' => $archive->getId(),
            ]);
        }

        return $this->render('archives/edit.html.twig', [
            'archive' => $archive,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="archives_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Archives $archive): Response
    {
        if ($this->isCsrfTokenValid('delete'.$archive->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($archive);
            $entityManager->flush();
        }

        return $this->redirectToRoute('archives_index');
    }
}
