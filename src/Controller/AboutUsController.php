<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutUsController extends BaseController
{
    //Méthode qui renvoie la vue "a propos de nous"
    #[Route('/about_us', name: 'app_about_us')]
    public function index(): Response
    {
        $this->addGlobalVariables();
        return $this->render('about_us/index.html.twig');
    }
}
