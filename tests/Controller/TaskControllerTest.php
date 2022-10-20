<?php

namespace Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @covers \App\Entity\TaskController
 */
class TaskControllerTest extends WebTestCase
{

    public function  testCanReadTasksList(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks');
        $this->assertResponseIsSuccessful();

    }


    public function  testCanAccessTaskCreationPage(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks/create');
        $this->assertResponseIsSuccessful();

    }

    public function  testCanCreateNewTask(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks/create');
//        $this->assertResponseIsSuccessful();

    }
}
