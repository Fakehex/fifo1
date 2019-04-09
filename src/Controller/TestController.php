<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/", name="accueil")
 */
class TestController extends AbstractController {
  public function index(){
    return $this->render('accueil/index.html.twig');
  }
}
