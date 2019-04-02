<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Evenement;
use Symfony\Component\HttpFoundation\Response;

class EvenementController extends AbstractController
{
    /**
     * @Route("/evenement", name="evenement")
     */
    public function index()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $event = new Evenement();
        $event->setTitre("firstTry");
        $event->setTexte("yeah body light weight");

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($event);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$event->getId().' et les texte '.$event->getTexte());
    }

    /**
     * @Route("/evenement/{id}", name="evenemnt_show")
     */
    public function show($id)
    {
        $event = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->find($id);

        if (!$event) {
            throw $this->createNotFoundException(
                "pas d'event pour " . $id
            );
        }

        return new Response('Vla le grand event : ' . $event->getTitre());
    }
}
