<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategorieForumRepository;
use App\Repository\TopicRepository;



/**
 * @Route("/forum")
 */
class ForumController extends AbstractController {
  /**
   * @Route("/", name="forum")
   */
  public function index(CategorieForumRepository $CategorieForumRepository){
    return $this->render('forum/index.html.twig', [
        'categories' => $CategorieForumRepository->findAll(),
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
   * @Route("{slugCategorie}/{slugTopic}", name="topic")
   */
  public function topic_affiche(CategorieForumRepository $CategorieForumRepository, TopicRepository $TopicRepository, $slugCategorie,$slugTopic){
    $topic = $TopicRepository->findOneBy(['slug'=>$slugTopic]);
    return $this->render('forum/topic.html.twig', [
        'topic' => $topic,
    ]);
  }
}
