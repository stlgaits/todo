<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Test\CustomTestCase;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

/**
 * @group security
 * @covers \App\Controller\SecurityController
 */
class SecurityControllerTest extends CustomTestCase
{
    use RefreshDatabaseTrait;

    public function testAnyoneCanAccessLoginForm(): void
    {
        $client = $this->createClient();
        $client->request('GET', '/login');
        $this->assertResponseIsSuccessful();
    }

    public function testLogin(): void
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/login');
        $user = $this->createUser("mary", "mypassword", "mary.funky@gmail.com");
        $client->loginUser($user);
        $this->assertResponseIsSuccessful();
    }

    public function testUserCanLoginViaForm(): void
    {
        $client = $this->createClient();
        $user = $this->createUser("mary", "mypassword", "mary.funky@gmail.com");
        $crawler = $client->request('GET', '/login');
        $client->loginUser($user);
        $client->submitForm('Se connecter', [
            'login_form[_username]' => 'mary',
            'login_form[_password]' => 'mypassword',
        ]);
        // user should be redirected to the homepage once logged in

        $this->assertResponseStatusCodeSame(302);
        $this->assertResponseIsSuccessful();
//        $this->markTestIncomplete();
    }


    public function testCannotLoginWithInvalidCredentials(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $this->markTestIncomplete();
    }


    public function testLogout(): void
    {
        $this->markTestSkipped();
        $client = static::createClient();
        $crawler = $client->request('GET', '/logout');
        // this isn't the correct assertion but I don't know which one to use to test a controller method which should never
        // be reached nor return anything....
        $this->assertResponseIsUnprocessable();
    }
}
