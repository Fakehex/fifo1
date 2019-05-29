<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use App\Form\ProfilType;
use App\Form\MdpType;
use App\Form\PictureType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use App\Service\FileUploader;


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

    /**
     * @Route("/", name="app_profil")
     */
    public function editProfil(Request $request,EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder, FileUploader $fileUploader): Response
    {
        var_dump($i);
        $user = $entityManager->getRepository(User::class)->findOneBy(['username' => $request->getSession()->get('username')]);
        $form = $this->createForm(ProfilType::class, $user);
        $formPicture = $this->createForm(PictureType::class, $user);
        $formMdp = $this->createForm(MdpType::class, $user);



        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Votre profil a bien été mis a jour');
            return $this->redirectToRoute('app_profil');
        }

        $formMdp->handleRequest($request);
        if ($formMdp->isSubmitted() && $formMdp->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Votre mot de passe a bien été mis a jour');
            return $this->redirectToRoute('app_profil');
        }

        $formPicture->handleRequest($request);
        if ($formPicture->isSubmitted() && $formPicture->isValid()) {
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $user->getPicture();
            $fileName = $fileUploader->upload($file);

            $user->setPicture($fileName);

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Votre image de profil a bien été mis a jour');
            return $this->redirectToRoute('app_profil');
        }

        return $this->render('user/profile.html.twig', [
          'user' => $user,
          'form' => $form->createView(),
          'formMdp' => $formMdp->createView(),
          'formPicture' => $formPicture->createView(),

        ]);
    }

}
