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
    $topics = $TopicRepository->findBy(['slug' => $categorie->getId()]);
    return $this->render('forum/topics.html.twig', [
        'topics' => $topics,
    ]);
  }
}
