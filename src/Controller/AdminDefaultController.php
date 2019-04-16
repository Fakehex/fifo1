<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
/**
 * @Route("/admin")
 */
class AdminDefaultController extends AbstractController {
  /**
   * @Route("/", name="admin")
   */
  public function index(){
    return $this->render('adminDefault/index.html.twig');
  }
  /**
   * @Route("/s1", name="s1")
   */
  public function s1(SessionInterface $session){
    $s1 = "ca marche";
    $session->set('s1',$s1);
    return $this->render('test.html.twig', ['s1' => "preparation"]);
  }
  /**
   * @Route("/s2", name="s2")
   */
  public function s2(SessionInterface $session){
    $s1 = $session->get('s1');
    return $this->render('test.html.twig',['s1' => $s1]);
  }
}
