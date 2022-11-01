<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Test\CustomTestCase;

/**
 * @group security
 * @covers \App\Controller\SecurityController
 */
final class SecurityControllerTest extends CustomTestCase
{
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
        $client->submitForm('Se connecter', [
            '_username' => 'mary',
            '_password' => 'mypassword',
        ]);
        // user should be redirected to the homepage once logged in
        $this->assertResponseStatusCodeSame(302);
        // @TODO: how can we test User Session to check that current user is indeed our test user
    }


    public function testCannotLoginWithInvalidCredentials(): void
    {
        $client = static::createClient();
        $user = $this->createUser("mary", "mypassword", "mary.funky@gmail.com");
        $crawler = $client->request('GET', '/login');
        $client->submitForm('Se connecter', [
            '_username' => 'emily',
            '_password' => 'mypassword',
        ]);
        $this->assertResponseStatusCodeSame(302);
        // @TODO: how can we test User Session to check that current user is indeed our test user
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
