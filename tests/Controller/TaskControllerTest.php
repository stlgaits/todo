<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Test\CustomTestCase;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

/**
 * @covers \App\Entity\TaskController
 */
class TaskControllerTest extends CustomTestCase
{
    use RefreshDatabaseTrait;

    public function  testCanReadTasksList(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks');
        $response = $client->getResponse()->getContent();
        $this->assertResponseIsSuccessful();
        $this->markTestIncomplete();
        // @TODO: test whether the response ACTUALLY contains a list of tasks

    }


    public function  testCanAccessTaskCreationPage(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks/create');
        $this->assertResponseIsSuccessful();

    }

    public function  testCanCreateNewTask(): void
    {
        $this->markTestSkipped();
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks/create');
        // @TODO: submit form data

        $this->assertResponseIsSuccessful();

    }
}
