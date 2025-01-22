<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends BaseController
{
    //Méthode qui renvoie la page d'accueil
    #[Route('/', name: 'home.index')]
    public function index(): Response
    {
        $this->addGlobalVariables();
        return $this->render('home/index.html.twig',);
    }


}
