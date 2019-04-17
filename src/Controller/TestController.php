<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;

class TestController extends AbstractController {
  /**
   * @Route("/", name="accueil")
   */
  public function index(Request $request){
    $s1 = $request->getSession()->get('s1');
    return $this->render('accueil/index.html.twig', ['s1' => $s1]);
  }
  public function connexionOuPas(Request $request){
    $deco = $request->getSession()->get('deco');
    if($deco == 'Deconnexion'){
      return $this->render(
          'accueil/deconnexion.html.twig'
      );
    }else{
      return $this->render(
          'accueil/connexion.html.twig'
      );
    }
  }
}
