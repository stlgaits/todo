<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Entity\Task;
use App\Entity\User;
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
    }

    public function testUserCanAccessTaskListViaALink(): void
    {
        $client = $this->createClient();
        $user = $this->getEntityManager()->getRepository(User::class)->find(1);
        $client->loginUser($user);
        $client->request('GET', '/');
        $client->clickLink("Consulter la liste des tâches");
        $this->assertResponseIsSuccessful();
        $this->assertSame("http://localhost/tasks", $client->getCrawler()->getBaseHref());
        $this->assertSame("http://localhost/tasks", $client->getCrawler()->getUri());
        $this->assertSelectorTextContains("button", "Marquer comme faite");
    }

    public function testCannotAccessTasksListAnonymously(): void
    {
        $client = $this->createClient();
        $client->request('GET', '/tasks');
        $client->followRedirects();
        $this->assertResponseRedirects('http://localhost/login', 302);
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
        $client->followRedirects();
        $user = $this->getEntityManager()->getRepository(User::class)->find(1);
        $client->loginUser($user);
        $client->request('GET', '/tasks/create');
        $client->submitForm('Ajouter', [
            'task[title]' => 'Faire un truc cool',
            'task[content]' => 'Mais faut vraiment que ce soit archi cool quoi',
        ]);
        $task = $this->getEntityManager()->getRepository(Task::class)->findOneBy(['title' => 'Faire un truc cool']);
        $this->assertNotNull($task);
        $this->assertEquals("Mais faut vraiment que ce soit archi cool quoi", $task->getContent());
        $this->assertFalse($task->isDone());
        $this->assertEquals($user->getEmail(), $task->getAuthor()->getEmail());
        $this->assertResponseIsSuccessful();
        $this->assertSame("http://localhost/tasks", $client->getCrawler()->getUri());
    }


    public function testCannotEditTaskAuthor(): void
    {
        $client = $this->createClient();
        $user1 = $this->getEntityManager()->getRepository(User::class)->find(1);
        $user2 = $this->getEntityManager()->getRepository(User::class)->find(2);
        $task = $this->getEntityManager()->getRepository(Task::class)->find(1);
        $taskId = $task->getId();
        $taskAuthor = $task->getAuthor();
        // I haven't found a better way yet to ensure we don't log in  the same user as the task's author given that
        // the tasks & user fixtures are generated at random and therefore we can't predict a task's author
        if ($taskAuthor === $user2) {
            $client->loginUser($user1);
        } else {
            $client->loginUser($user2);
        }
        $client->request("GET", "/tasks/$taskId/edit");
        $client->submitForm('Modifier', [
            'task[title]' => 'Faire un truc assez cool',
            'task[content]' => 'Mais faut vraiment que ce soit pas non plus trop cool quoi',
        ]);
        $client->followRedirects();
        $this->assertNotNull($task);
        $this->assertSame($taskAuthor, $task->getAuthor());
        $this->assertResponseRedirects('/tasks', 303);
    }

    public function testOnlyAdminUserCanDeleteDefaultTasks(): void
    {
        $this->markTestIncomplete();
        $client = static::createClient();
        $admin = $this->createAdminUser('admin1', 'password4admin', 'admin@admin.com');

        $client->request('GET', '/tasks/{id}/delete');
    }

    public function testTaskCanBeEditedByItsAuthor(): void
    {
        $this->markTestIncomplete();
        $client = static::createClient();
        $client->request('GET', '/tasks/{id}/edit');
    }

    public function testCannotEditATaskOfWhichUserIsNotTheAuthor(): void
    {
        $this->markTestIncomplete();
        $client = static::createClient();
        $client->request('GET', '/tasks/{id}/edit');
    }

    public function testUserCanToggleATask(): void
    {
        $this->markTestIncomplete();
        $client = static::createClient();
        $client->request('GET', '/tasks/{id}/toggle');
    }

    public function testAuthorCanDeleteTheirOwnTask(): void
    {
        $this->markTestIncomplete();
        $client = static::createClient();
        $client->request('GET', '/tasks/{id}/delete');
    }

    public function testCannotDeleteTaskOfWhichUserIsNotTheAuthor(): void
    {
        $this->markTestIncomplete();
        $client = static::createClient();
        $client->request('GET', '/tasks/{id}/delete');
    }
}
