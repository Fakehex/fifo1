<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CategorieForumRepository;
use App\Repository\TopicRepository;
use App\Repository\UserRepository;
use App\Entity\Commentaire;
use App\Entity\Topic;
use App\Form\TopicUserType;
use App\Form\CommentaireUserType;



/**
 * @Route("/forum")
 */
class ForumController extends AbstractController {
  /**
   * @Route("/", name="forum")
   */
  public function index(CategorieForumRepository $CategorieForumRepository, TopicRepository $TopicRepository){

    return $this->render('forum/index.html.twig', [
        'categories' => $CategorieForumRepository->findAll(),
        'topics' => $TopicRepository->findAll(),
    ]);
  }
  /**
   * @Route("/{slugCategorie}", name="topics")
   */
  public function topics(CategorieForumRepository $CategorieForumRepository, TopicRepository $TopicRepository, $slugCategorie){
    $categorie = $CategorieForumRepository->findOneBy(['slug'=>$slugCategorie]);
    $topics = $TopicRepository->findBy(['categorieForum' => $categorie]);
    return $this->render('forum/topics.html.twig', [
        'topics' => $topics,
        'slugCategorie'=>$slugCategorie,
    ]);
  }
  /**
   * @Route("/{slugCategorie}/{slugTopic}", name="topic")
   */
  public function topic_affiche(Request $request,UserRepository $UserRepository,CategorieForumRepository $CategorieForumRepository, TopicRepository $TopicRepository, $slugCategorie,$slugTopic){
    $topic = $TopicRepository->findOneBy(['slug'=>$slugTopic]);
    if($request->getSession()->has('username')){
      $user = $UserRepository->findOneBy(['username'=>$request->getSession()->get('username')])/*--------BESOIN DU USER-----------------*/;
      $commentaire = new Commentaire();
      $commentaire->setUser($user);
      $commentaire->setTopic($topic);
      $commentaire->setPublishedAt(new \DateTime());
      $form = $this->createForm(CommentaireUserType::class, $commentaire);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($commentaire);
          $topic->addNbCommentaires();
          $entityManager->persist($topic);
          $entityManager->flush();
      }
    }else{
      return $this->render('forum/topic.html.twig', [
          'topic' => $topic,
          'isConnected' => false,
      ]);
    }

    return $this->render('forum/topic.html.twig', [
        'topic' => $topic,
        'isConnected' => true,
        'form' => $form->createView(),
    ]);
  }

  /**
   * @Route("/nouveau/{slugCategorie}/debug", name="nouveau_topic")
   */
  public function nouveau_topic(Request $request,UserRepository $UserRepository, CategorieForumRepository $CategorieForumRepository, $slugCategorie): Response
  {
      $username = $request->getSession()->get('username');
      if($request->getSession()->has('username')){

        $categorie =  $CategorieForumRepository->findOneBy(['slug'=>$slugCategorie]);
        $user = $UserRepository->findOneBy([ 'username' => $username ]);

        $topic = new Topic();
        $topic->setDate(new \DateTime());
        $topic->setUser($user);
        $topic->setNbCommentaires(0);
        $topic->setCategorieForum($categorie);
        $form = $this->createForm(TopicUserType::class, $topic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($topic);
            $entityManager->flush();

            return $this->redirectToRoute('topics', [
                'slugCategorie' => $categorie->getSlug(),
            ]);
        }

        return $this->render('forum/nouveau_topic.html.twig', [
            'categorie' => $categorie,
            'topic' => $topic,
            'form' => $form->createView(),
        ]);

      }
          return $this->redirectToRoute('app_login');


  }

}
