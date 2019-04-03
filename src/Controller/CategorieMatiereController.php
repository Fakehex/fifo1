<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategorieMatiereController extends AbstractController
{
    /**
     * @Route("/categorieMatiere", name="categorie_matiere")
     */
    public function index()
    {

        return $this->render('categorie_matiere/index.html.twig', [
            'controller_name' => 'CategorieMatiereController',
        ]);
    }
}
