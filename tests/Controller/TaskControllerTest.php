<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Entity\Task;
use App\Test\CustomTestCase;

/**
 * @covers \App\Entity\TaskController
 */
final class TaskControllerTest extends CustomTestCase
{

    public function testUserCanReadTasksList(): void
    {
        $client = $this->createClient();
        $user = $this->createUser("bernard", "notbianca", "bernard@disney.fr");
        $client->loginUser($user);
        $client->request('GET', '/tasks');
        $this->assertResponseIsSuccessful();
        // @TODO: test whether the response ACTUALLY contains a list of tasks
        $this->assertSelectorExists('form[name="task"]');
        $this->assertSelectorExists('input[id="task_title"]');
        $this->assertSelectorExists('textarea[id="task_content"]');
        $this->assertSelectorExists('button[type="submit"]');
    }

    public function testUserCanAccessTaskListViaALink(): void
    {
            $this->markTestIncomplete();
    }

    public function testCannotAccessTasksListAnonymously(): void
    {
        $client = $this->createClient();
        $client->request('GET', '/tasks');
        $client->followRedirects();
        $this->assertResponseRedirects('http://localhost/login', 302);
        $this->markTestIncomplete();
    }


    public function testCannotCreateTaskAnonymously(): void
    {
        $client = $this->createClient();
        $client->followRedirects();
        $client->request('GET', '/tasks/create');
        $this->assertResponseStatusCodeSame(200);
        $this->assertRouteSame(
            'login',
            [],
            'If authenticated anonymously, user should not be able to access task-creation form and should be redirected to login page'
        );
    }

    public function testLoggedInUsersCanAccessTaskCreationPage(): void
    {
        $client = $this->createClient();
        $user = $this->createUser("bernard", "notbianca", "bernard@disney.fr");
        $client->loginUser($user);
        $client->request('GET', '/tasks/create');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form[name="task"]');
        $this->assertSelectorExists('input[id="task_title"]');
        $this->assertSelectorExists('textarea[id="task_content"]');
        $this->assertSelectorExists('button[type="submit"]');
    }

    public function testUserCanCreateNewTask(): void
    {
        $client = $this->createClient();
        $user = $this->createUser("mario", "notluigi!", "mario.bros@nintendo.fr");
        $client->loginUser($user);
//        $session = $this->getContainer()->get('session');
        // @TODO: unsure why but so far mock logged-in user is actually redirected to login page when trying to
        // get /tasks/create
        $response = $client->request('GET', '/tasks/create');
        $client->submitForm('Ajouter', [
            'task[title]' => 'Faire un truc cool',
            'task[content]' => 'Mais faut vraiment que ce soit archi cool quoi',
        ]);
        $task = $this->getEntityManager()->getRepository(Task::class)->findOneBy(['title' => 'Faire un truc cool']);
        $this->assertResponseRedirects('task_list');
        $this->assertNotNull($task);
        $this->assertEquals("Mais faut vraiment que ce soit archi cool quoi", $task->getContent());
        $this->assertFalse($task->isDone());
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

    public function testUserCanToggleATask(): void
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
