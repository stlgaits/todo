<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Entity\Task;
use App\Test\CustomTestCase;

/**
 * @covers \App\Entity\TaskController
 */
class TaskControllerTest extends CustomTestCase
{

    public function testUserCanReadTasksList(): void
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/tasks');
        $response = $client->getResponse()->getContent();
        $this->assertResponseIsSuccessful();
        $this->markTestIncomplete();
        // @TODO: test whether the response ACTUALLY contains a list of tasks
        // @TODO: ensure route is only accessible to logged in users
    }

    public function testCannoReadTasksListAnonymously(): void
    {
        $this->markTestIncomplete();
    }


    public function testCannotCreateTaskAnonymously(): void
    {
        $this->markTestIncomplete();
    }

    public function testLoggedInUsersCanAccessTaskCreationPage(): void
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/tasks/create');
        $this->assertResponseIsSuccessful();
        $this->markTestIncomplete();
    }

    public function testUserCanCreateNewTask(): void
    {
        $client = $this->createClient();
        $user = $this->createUser("mario", "notluigi", "mario.bros@nintendo.fr");
        $client->loginUser($user);
        $client->request('GET', '/tasks/create');
        $client->submitForm('Ajouter', [
            'task[title]' => 'Faire un truc cool',
            'task[content]' => 'Mais faut vraiment que ce soit archi cool quoi',
        ]);
        $task = $this->getEntityManager()->getRepository(Task::class)->findOneBy(['title' => 'Faire un truc cool']);
        $this->assertResponseStatusCodeSame(302);
        $this->assertResponseRedirects('/tasks', 302);
        $this->assertNotNull($task);
        $this->assertEquals("Mais faut vraiment que ce soit archi cool quoi", $task->getContent());
        $this->assertFalse($task->isDone());
//        $this->assertRouteSame();
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

    public function testAuthorCanDeleteTheirOwnTask(): void
    {
        $this->markTestIncomplete();
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks/{id}/delete');
    }

    public function testCannotDeleteTaskOfWhichUserIsNotTheAuthor(): void
    {
        $this->markTestIncomplete();
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks/{id}/delete');
    }
}
