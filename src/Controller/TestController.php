<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;

class TestController extends AbstractController {
  /**
   * @Route("/111", name="accueilll")
   */
  public function index(Request $request){
    $s1 = $request->getSession()->get('s1');
    return $this->render('accueil/index.html.twig', ['s1' => $s1]);
  }

}
