<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @covers \App\Entity\DefaultController
 */
class DefaultControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        self::ensureKernelShutdown();
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('h1', "Bienvenue sur Todo List, l'application vous permettant de gérer l'ensemble de vos tâches sans effort !");
    }

    public function testVisitingWhileLoggedIn()
    {
        $client = static::createClient();

        // get or create the user somehow (e.g. creating some users only
        // for tests while loading the test fixtures)
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('jane.doe@example.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        // user is now logged in, so you can test protected resources
        $client->request('GET', '/');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello Jane!');
    }
}
