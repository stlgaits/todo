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

    public function testCanReadTasksList(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks');
        $response = $client->getResponse()->getContent();
        $this->assertResponseIsSuccessful();
        $this->markTestIncomplete();
        // @TODO: test whether the response ACTUALLY contains a list of tasks
    }

    public function testCanAccessTaskCreationPage(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks/create');
        $this->assertResponseIsSuccessful();
    }

    public function testUserCanCreateNewTask(): void
    {
        $this->markTestSkipped();
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks/create');
        // @TODO: submit form data
        $this->assertResponseIsSuccessful();
    }

    public function testTaskAuthorIsSetToCurrentUserWhenCreated(): void
    {
        $this->markTestSkipped();
    }

    public function testCannotEditTaskAuthor(): void
    {
        $this->markTestSkipped();
    }

    public function testOnlyAdminUserCanDeleteDefaultTasks(): void
    {
        $this->markTestIncomplete();
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks/{id}/delete');
    }

    public function testTaskCanBeEditedByItsAuthor(): void
    {
        $this->markTestIncomplete();
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks/{id}/edit');
    }

    public function testCannotEditATaskOfWhichUserIsNotTheAuthor(): void
    {
        $this->markTestIncomplete();
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks/{id}/edit');
    }

    public function testCanToggleATask(): void
    {
        $this->markTestIncomplete();
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks/{id}/toggle');
    }

    public function testCanDeleteATask(): void
    {
        $this->markTestIncomplete();
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks/{id}/delete');
    }
}
