<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EvenementRepository;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(Request $request,EvenementRepository $evenementRepository )
    {
        $co = $request->getSession()->get('co');
        $username = $request->getSession()->get('username');
        return $this->render('accueil/index.html.twig',['co' => $co, 'username' => $username, 'evenements' => $evenementRepository->findAll()]);

    }

    public function connexionOuPas(Request $request){
        $co = $request->getSession()->get('co');
        if($co == 'true'){
            return $this->render(
                'accueil/deconnexion.html.twig'
            );
        }else{
            return $this->render('accueil/connexion.html.twig');
        }
    }

}
