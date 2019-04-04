<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategorieMatiereRepository;
use App\Repository\MatiereRepository;
use Symfony\Component\HttpFoundation\Response;


/**
 * @Route("/archives")
 */
class PageArchivesController extends AbstractController
{
    /**
     * @Route("/", name="page_archives")
     */
    public function index(CategorieMatiereRepository $CategorieMatiereRepository )
    {
      return $this->render('page_archives/index.html.twig', [
          'categories' => $CategorieMatiereRepository->findAll(),
      ]);
    }
    /**
     * @Route("/liste_des_matieres/{slug}", name="liste_matieres", methods={"GET"})
     */
    public function listeMatieres(MatiereRepository $MatiereRepository ,CategorieMatiereRepository $CategorieMatiereRepository,$slug)
    {
      $categorie = $CategorieMatiereRepository->findOneBy(['slug' => $slug]);
      $matieres = $MatiereRepository->findBy(['categorie' => $categorie->getId()]);
      return $this->render('page_archives/liste_matieres.html.twig', [
          'matieres' => $matieres,
      ]);
    }
}
