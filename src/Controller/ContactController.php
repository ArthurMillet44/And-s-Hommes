<?php

namespace App\Controller;

use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends BaseController
{
    //Méthode qui renvoie la page de contact
    #[Route('/contact', name: 'app_contact')]
    public function index(): Response
    {
        if ($this->isGranted('ROLE_USER')) {
            $this->addGlobalVariables();
            return $this->render('contact/index.html.twig', [
                'controller_name' => 'ContactController',
            ]);
        }else{
            return $this->redirectToRoute('app_login');
        }
    }

    #[Route('/InsertMessage', name: 'app_contact_envoie')]
    public function InsertMessage(MessageRepository $message_repository) : RedirectResponse{
        $message_repository->AjoutMessage($this->getUser()->getId(),$_POST["messageBody"]);
        return $this->redirectToRoute('home.index');
    }

}
