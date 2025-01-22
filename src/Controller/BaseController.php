<?php

namespace App\Controller;

use App\Repository\PanierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Twig\Environment;


class BaseController extends AbstractController
{
    private PanierRepository $panierRepository;
    private Environment $environment;

    public function __construct(PanierRepository $panierRepository, Environment $environment){
        $this->panierRepository = $panierRepository;
        $this->environment = $environment;
    }
    //Ajout d'un variable global twig pour afficher le nombre d'élément dans le panier
    public function addGlobalVariables(): JsonResponse
    {
        $user = $this->getUser();
        if ($user != null){
            $nbElementPanier = $this->panierRepository->countPaniersForUser($user);
        }else{
            $nbElementPanier = 0;
        }


        $this->environment->addGlobal('nbElementPanier', $nbElementPanier);
        return new JsonResponse(['nbElements' => $nbElementPanier]);
    }
}

