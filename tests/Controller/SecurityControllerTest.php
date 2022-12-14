<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Test\CustomTestCase;

/**
 * @group security
 * @covers \App\Controller\SecurityController
 * @covers \App\Security\Voter\TaskVoter
 * @uses \App\Entity\User
 */
final class SecurityControllerTest extends CustomTestCase
{
    /**
     * @covers \App\Controller\SecurityController::login
     */
    public function testAnyoneCanAccessLoginForm(): void
    {
        $client = $this->createClient();
        $client->request('GET', '/login');
        $this->assertResponseIsSuccessful();
    }

    /**
     * @covers \App\Controller\SecurityController::login
     */
    public function testLogin(): void
    {
        $client = $this->createClient();
        $client->request('GET', '/login');
        $user = $this->createUser("mary", "mypassword", "mary.funky@gmail.com");
        $client->loginUser($user);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @covers \App\Controller\SecurityController::login
     */
    public function testUserCanLoginViaForm(): void
    {
        $client = $this->createClient();
        $this->createUser("mary", "mypassword", "mary.funky@gmail.com");
        $client->request('GET', '/login');
        $client->submitForm('Se connecter', [
            '_username' => 'mary',
            '_password' => 'mypassword',
        ]);
        // user should be redirected to the homepage once logged in
        $this->assertResponseStatusCodeSame(302);
        // @TODO: how can we test User Session to check that current user is indeed our test user
    }


    /**
     * @covers \App\Controller\SecurityController::login
     */
    public function testCannotLoginWithInvalidCredentials(): void
    {
        $client = static::createClient();
        $this->createUser("mary", "mypassword", "mary.funky@gmail.com");
        $client->request('GET', '/login');
        $client->submitForm('Se connecter', [
            '_username' => 'emily',
            '_password' => 'mypassword',
        ]);
        $client->followRedirect();
//        $this->assertResponseStatusCodeSame(302);
        $this->assertSelectorExists('.alert.alert-danger');
        // @TODO: how can we test User Session to check that current user is indeed our test user
//        $this->markTestIncomplete();
    }


    /**
     * @covers \App\Controller\SecurityController::logout
     */
    public function testLogout(): void
    {
        $this->markTestSkipped();
        $client = static::createClient();
        $client->request('GET', '/logout');
        // this isn't the correct assertion but I don't know which one to use to test a controller method which should never
        // be reached nor return anything....
        $this->assertResponseIsUnprocessable();
    }
}
