<?php

namespace App\Tests\Controller;

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
}
