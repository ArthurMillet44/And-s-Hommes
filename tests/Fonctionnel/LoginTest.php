<?php

namespace App\Tests\Fonctionnel;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class LoginTest extends WebTestCase
{

    //Test qui montre que le /login fais bien la redirection si les informations sont valides
    public function testLogin(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $this->assertResponseIsSuccessful();

        $submitButton = $crawler->selectButton("Se connecter");
        $form = $submitButton->form();
        $form['_username'] = "john.doe@gmail.com";
        $form['_password'] = "password";

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }

    //Test qui montre que si les informations sont mauvaises la page /login est renvoyé
    public function testLoginInvalid(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $this->assertResponseIsSuccessful();

        $submitButton = $crawler->selectButton("Se connecter");
        $form = $submitButton->form();
        $form['_username'] = "john.doe@gmail.com";
        $form['_password'] = "badpassword";

        $client->submit($form);

        $response = $client->getResponse();
        $this->assertTrue($response->isRedirect('http://localhost/login'));
    }
}
