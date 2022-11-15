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
        $user = $this->createUser("louis", "notbianca", "louis@disney.fr");
        $client->loginUser($user);
        $client->request('GET', '/');
        $client->clickLink("Consulter la liste des tâches");
        $this->assertResponseRedirects("/tasks", 302);
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
        $user = $this->createUser("mario", "notluigi!", "mario.bros@nintendo.fr");
        $client->loginUser($user);
        // @TODO: unsure why but so far mock logged-in user is actually redirected to login page when trying to
        // get /tasks/create
        $client->request('GET', '/tasks/create');
        $client->submitForm('Ajouter', [
            'task[title]' => 'Faire un truc cool',
            'task[content]' => 'Mais faut vraiment que ce soit archi cool quoi',
        ]);
        $task = $this->getEntityManager()->getRepository(Task::class)->findOneBy(['title' => 'Faire un truc cool']);
        $this->assertNotNull($task);
        $this->assertEquals("Mais faut vraiment que ce soit archi cool quoi", $task->getContent());
        $this->assertFalse($task->isDone());
        $this->assertSame($user, $task->getAuthor());
        $this->assertResponseRedirects('task_list');
        $this->markTestIncomplete();
    }


    public function testCannotEditTaskAuthor(): void
    {
        $client = $this->createClient();
        $user1 = $this->createUser("mario1", "notluigi1!", "mario1.bros@nintendo.fr");
        $user2 = $this->createUser("sophie", "bonsoir!", "sophie.marceau@nintendo.fr");
        $task = $this->createTask("Defeat enemies", "While not forgetting to save the princess", $user1);
        $taskId = $task->getId();
        $client->loginUser($user2);
        $client->followRedirects();
        $client->request("GET", "/tasks/$taskId/edit");
        $client->submitForm('Modifier', [
            'task[title]' => 'Faire un truc assez cool',
            'task[content]' => 'Mais faut vraiment que ce soit pas non plus trop cool quoi',
        ]);
        $client->followRedirects();
        $this->assertNotNull($task);
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame("div[class=alert-success]", "<strong>Superbe !</strong> La tâche a bien été modifiée.");
        $this->assertSame($user1, $task->getAuthor());
        $this->assertResponseRedirects('task_list');
    }

    public function testOnlyAdminUserCanDeleteDefaultTasks(): void
    {
        $this->markTestIncomplete();
        $client = static::createClient();
        $admin = $this->createAdminUser('admin1', 'password4admin', 'admin@admin.com');

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
