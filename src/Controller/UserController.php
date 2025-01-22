<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\PanierRepository;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Psr\Container\ContainerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class UserController extends BaseController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier,PanierRepository $panierRepository, Environment $environment)
    {
        parent::__construct($panierRepository, $environment);
        $this->emailVerifier = $emailVerifier;

    }
    //Méthode pour accéder à la page du compte
    #[Route('/account', name: 'app_user')]
    public function index(): Response
    {
        //Vérification que l'utlisateur est connecté sinon il est redirigé vers la page de login
        if ($this->isGranted('ROLE_USER')) {
            $this->addGlobalVariables();
            return $this->render('user/index.html.twig', ['user' => $this->getUser(),
            ]);
        }else{
            return $this->redirectToRoute('app_login');
        }
    }

    //Méthode pour accéder à la page d'édition du compte.
    #[Route('/account/formEdit', name: 'app_user_form_edit_account')]
    public function FormEditAccount(): Response
    {
        $this->addGlobalVariables();
        return $this->render('user/form_account.html.twig', ['user' => $this->getUser(),
        ]);
    }

    //Méthode pour pouvoir éditer son compte.
    #[Route('/account/editAccount', name: 'app_user_edit_account')]
    public function editAccount(EntityManagerInterface $entityManager): Response{
        $this->addGlobalVariables();
        $user = $this->getUser();
        $user->setSurname($_POST["surname"]);
        $user->setName($_POST["name"]);
        $user->setEmail($_POST["email"]);
        $user->setIsVerified(false);
        $entityManager->persist($user);
        $entityManager->flush();
        //Envoie du mail bloqué par le pare feux de l'iut
        /*
        $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
            (new TemplatedEmail())
                ->from(new Address('sae.andshommes@gmail.com', 'Mail AndsHommes'))
                ->to($user->getEmail())
                ->subject('Please Confirm your Email')
                ->htmlTemplate('registration/confirmation_email.html.twig')
        );
        // do anything else you need here, like send an email
        */
        return $this->redirectToRoute('app_user');
    }
}
