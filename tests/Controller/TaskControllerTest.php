<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Test\CustomTestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

/**
 * @covers \App\Entity\TaskController
 */
class TaskControllerTest extends CustomTestCase
{
    use ReloadDatabaseTrait;

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
