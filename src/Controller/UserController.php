<?php


namespace App\Controller;

use App\Entity\Topic;
use App\Form\TopicType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;

/**
 * @Route("/profil")
 */
class UserController extends AbstractController
{
    private $entityManager;
    private $passwordEncoder;


    public function __construct(entityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder){
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
    }


    public function editProfil(Request $request, $entityManager): Response
    {
        $user = $entityManager->getRepository(User::class)->findOneBy(['username' => $request->getSession()->get('username')]);
        $form = $this->createForm(ProfilType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('topic_index', [
                'id' => $user->getId(),
            ]);
        }

        return $this->render('topic/edit.html.twig', [
            'topic' => $user,
            'form' => $form->createView(),
        ]);
    }


}