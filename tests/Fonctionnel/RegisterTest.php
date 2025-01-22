<?php

namespace App\Tests\Fonctionnel;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class RegisterTest extends WebTestCase
{
    //Test qui montre que le /register fais bien la redirection si le formulaire est valid
    public function testInscriptionValid(): void
    {

        $client = static::createClient();
        $crawler = $client->request('GET', '/register');

        $container = static::getContainer();
        $this->userRepository = $container->get(UserRepository::class);
        $tabUser = $this->userRepository->findBy(["email"=>"john.doe@gmail.com"]) ;
        if (sizeof($tabUser) == 1){
            $this->userRepository->DeleteUser($tabUser[0]->getId());
        }

        $this->assertResponseIsSuccessful();

        $submitButton = $crawler->selectButton("registration_form[submit]");
        $form = $submitButton->form();
        $form['registration_form[surname]'] = "Doe";
        $form['registration_form[name]'] = "John";
        $form['registration_form[dateOfBirth]'] = "2000-01-01";
        $form['registration_form[email]'] = "john.doe@gmail.com";
        $form['registration_form[plainPassword]'] = "password";
        $form['registration_form[agreeTerms]']->tick();

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

    }
    //Test qui montre que le /register ne fais pas la redirection si le formulaire est invalid
    public function testInscriptionInvalid(): void
    {

        $client = static::createClient();
        $crawler = $client->request('GET', '/register');

        $this->assertResponseIsSuccessful();

        $submitButton = $crawler->selectButton("registration_form[submit]");
        $form = $submitButton->form();

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

    }
}
