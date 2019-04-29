<?php


namespace App\Controller;

use App\Form\UserType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class RegisterController extends Controller
{
    /**
     * @Route("/register", name="app_register")
     */

    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder){
        $user = new User();
        $form = $this->createForm(UserType::class, $user);


        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('notice', 'Votre compte est créé'
            );
            return $this->redirectToRoute('accueil');
        }

        return $this->render('user/_form.html.twig', ['form' => $form->createView(), 'mainNavRegistration' => true, 'title' => 'Inscription']);
    }
}