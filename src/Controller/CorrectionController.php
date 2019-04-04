<?php

namespace App\Controller;

use App\Entity\Correction;
use App\Form\CorrectionType;
use App\Repository\CorrectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\FileUploader;

/**
 * @Route("/admin/correction")
 */
class CorrectionController extends AbstractController
{
    /**
     * @Route("/", name="correction_index", methods={"GET"})
     */
    public function index(CorrectionRepository $correctionRepository): Response
    {
        return $this->render('correction/index.html.twig', [
            'corrections' => $correctionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="correction_new", methods={"GET","POST"})
     */
    public function new(Request $request,FileUploader $fileUploader): Response
    {
        $correction = new Correction();
        $form = $this->createForm(CorrectionType::class, $correction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $correction->getCorrection();
            $fileName = $fileUploader->upload($file);

            $correction->setCorrection($fileName);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($correction);
            $entityManager->flush();

            return $this->redirectToRoute('correction_index');
        }

        return $this->render('correction/new.html.twig', [
            'correction' => $correction,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="correction_show", methods={"GET"})
     */
    public function show(Correction $correction): Response
    {
        return $this->render('correction/show.html.twig', [
            'correction' => $correction,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="correction_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Correction $correction, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(CorrectionType::class, $correction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $correction->getSujet();
            $fileName = $fileUploader->upload($file);

            $correction->setCorrection($fileName);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('correction_index', [
                'id' => $correction->getId(),
            ]);
        }

        return $this->render('correction/edit.html.twig', [
            'correction' => $correction,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="correction_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Correction $correction): Response
    {
        if ($this->isCsrfTokenValid('delete'.$correction->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($correction);
            $entityManager->flush();
        }

        return $this->redirectToRoute('correction_index');
    }
}
