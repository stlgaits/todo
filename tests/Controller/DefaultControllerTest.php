<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Test\CustomTestCase;

/**
 * @covers \App\Entity\DefaultController
 */
final class DefaultControllerTest extends CustomTestCase
{
    public function testIndex(): void
    {
        self::ensureKernelShutdown();
        $client = self::createClient();

        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('h1', "Bienvenue sur Todo List, l'application vous permettant de gérer l'ensemble de vos tâches sans effort !");
    }

    public function testVisitingWhileLoggedIn(): void
    {
        $client = self::createClient();

        $user = $this->createUser("mary", "mypassword", "mary.funky@gmail.com");
        // simulate $user being logged in
        $client->loginUser($user);

        // user is now logged in, so you can test protected resources
        $client->request('GET', '/');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains("h1", "Bienvenue sur Todo List, l'application vous permettant de gérer l'ensemble de vos tâches sans effort !");
    }
}
