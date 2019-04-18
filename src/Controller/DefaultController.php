<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;


class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(Request $request)
    {
        $session = $request->getSession()->get('co');
        $session2 = $request->getSession()->get('username');

        return $this->render('accueil/index.html.twig',['co' => $session, 'username' => $session2]);

    }

    public function connexionOuPas(Request $request){
        $deco = $request->getSession()->get('co');
        if($deco == 'Deconnexion'){
            return $this->render(
                'accueil/deconnexion.html.twig'
            );
        }else{
            return $this->render('accueil/connexion.html.twig');
        }
    }



}