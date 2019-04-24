<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/profil")
 */
class UserController extends AbstractController
{
    private $entityManager;

    public function __construct(entityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="profil")
     */
    public function index(Request $request)
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => $request->getSession()->get('username')]);


        return $this->render('user/profile.html.twig',[ 'user' => $user]);

    }

}