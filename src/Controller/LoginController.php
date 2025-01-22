<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends BaseController
{
    #[Route(path: '/login', name: 'app_login', methods: ['GET','POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $this->addGlobalVariables();
        //Takes the value of the connection error if there is one.
        $error = $authenticationUtils->getLastAuthenticationError();

        //Save the last username if there is one
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    //Empty method that serves for the logout. It is intercepted by the firewall to realize the logout
    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {}
}
