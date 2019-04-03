<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArchivesController extends AbstractController
{
    /**
     * @Route("/archives", name="archives")
     */
    public function index()
    {
        return $this->render('archives/index.html.twig', [
            'controller_name' => 'ArchivesController',
        ]);
    }
}
