<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategorieMatiereRepository;
use App\Repository\MatiereRepository;
use App\Repository\ArchivesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Service\FileUploader;
use App\Entity\Correction;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


/**
 * @Route("/archives")
 */
class PageArchivesController extends AbstractController
{
    /**
     * @Route("/", name="page_archives")
     */
    public function index(MatiereRepository $MatiereRepository, CategorieMatiereRepository $CategorieMatiereRepository )
    {
      return $this->render('page_archives/index.html.twig', [
          'categories' => $CategorieMatiereRepository->findAll(),
          'matieres' => $MatiereRepository->findAll(),
      ]);
    }
    /**
     * @Route("/matieres/{slug}", name="liste_matieres", methods={"GET"})
     */
    public function listeMatieres(MatiereRepository $MatiereRepository ,CategorieMatiereRepository $CategorieMatiereRepository,$slug)
    {
      $categorie = $CategorieMatiereRepository->findOneBy(['slug' => $slug]);
      $matieres = $MatiereRepository->findBy(['categorie' => $categorie->getId()]);
      return $this->render('page_archives/liste_matieres.html.twig', [
          'matieres' => $matieres,
          'slugCategorie' => $slug,
      ]);
    }
    /**
     * @Route("/matieres/{slugCategorie}/{slugMatiere}", name="matiere", methods={"GET"})
     */
    public function ShowMatiere(MatiereRepository $MatiereRepository ,CategorieMatiereRepository $CategorieMatiereRepository,$slugCategorie, $slugMatiere)
    {
      $categorie = $CategorieMatiereRepository->findOneBy(['slug' => $slugCategorie]);
      $matiere = $MatiereRepository->findOneBy(['categorie' => $categorie->getId(),'slug' => $slugMatiere]);
      $archives = $matiere->getArchives();
      return $this->render('page_archives/matiere.html.twig', [
          'matiere' => $matiere,
          'archives' => $archives,
      ]);
    }
    /**
     * @Route("/ajouterCorrection/{id}", name="ajouter_correction", methods={"GET","POST"})
     */
    public function AjouterCorrection(ArchivesRepository $ArchivesRepository,Request $request,FileUploader $fileUploader ,$id)
    {
      $archive = $ArchivesRepository->findOneBy(['id' => $id]);

      $correction = new Correction();
      $correction->setArchive($archive);
      $correction->setDate(new \DateTime());
      $correction->setPocebleu(0);
      $form = $this->createFormBuilder($correction)
            ->add('titre', TextType::class)
            ->add('correction',FileType::class, ['label' => 'Sujet (PDF file)', 'data_class' => null])
          /*  ->add('save', SubmitType::class, ['label' => 'Ajouter la Correction']) */
            ->getForm();
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

      return $this->render('page_archives/ajouter_correction.html.twig', [
          'archive' => $archive,
          'correction' => $correction,
          'form' => $form->createView(),
      ]);
    }
    /**
     * @Route("/corrections/{id}", name="corrections", methods={"GET"})
     */
    public function Corrections(ArchivesRepository $ArchivesRepository,$id)
    {
      $archive = $ArchivesRepository->findOneBy(['id' => $id]);
      $corrections = $archive->getCorrections();
      return $this->render('page_archives/corrections.html.twig', [
          'corrections' => $corrections,
          'archive' => $archive,
      ]);
    }
}
