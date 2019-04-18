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
        $session = $request->getSession()->get('deco');

        return $this->render('accueil/index.html.twig',['deco' => $session]);

    }

    public function connexionOuPas(Request $request){
        $deco = $request->getSession()->get('deco');
        if($deco == 'Deconnexion'){
            return $this->render(
                'accueil/deconnexion.html.twig'
            );
        }else{
            return $this->render('accueil/connexion.html.twig');
        }
    }



}