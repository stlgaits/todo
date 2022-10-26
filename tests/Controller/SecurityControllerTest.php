<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Test\CustomTestCase;

/**
 * @group security
 * @covers \App\Controller\SecurityController
 */
class SecurityControllerTest extends CustomTestCase
{
    public function testAnyoneCanAccessLoginForm(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $this->assertResponseIsSuccessful();
    }

    public function testLogin(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $user = $this->createUser("mary", "mypassword", "mary.funky@gmail.com");
        $client->loginUser($user);
        $this->markTestIncomplete();
        $this->assertResponseIsSuccessful();
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
