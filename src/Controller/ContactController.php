<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Contact;
use App\Form\ContactType;

class ContactController extends AbstractController
{

    /**
     * @Route("/contact", name="contact.show")
     * @return Response
     */
    public function show(Request $request): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->render('contact/show.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        return $this->render('contact/show.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}