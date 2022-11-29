<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Entity\Task;
use App\Entity\User;
use App\Test\CustomTestCase;

/**
 * @group task
 * @covers \App\Controller\TaskController
 * @uses \App\Security\Voter\TaskVoter
 * @uses \App\Entity\Task
 * @uses \App\Repository\TaskRepository
 * @uses \App\Entity\User
 */
final class TaskControllerTest extends CustomTestCase
{
    /**
     * @covers \App\Controller\TaskController::list
     */
    public function testUserCanReadTasksList(): void
    {
        $client = $this->createClient();
        $user = $this->createUser("bernard", "notbianca", "bernard@disney.fr");
        $client->loginUser($user);
        $client->request('GET', '/tasks');
        $this->assertResponseIsSuccessful();
    }

    /**
     * @covers \App\Controller\TaskController::list
     * @uses \App\Controller\DefaultController::index
     */
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

    /**
     * @covers \App\Controller\TaskController::list
     */
    public function testCannotAccessTasksListAnonymously(): void
    {
        $client = $this->createClient();
        $client->request('GET', '/tasks');
        $client->followRedirects();
        $this->assertResponseRedirects('http://localhost/login', 302);
    }


    /**
     * @covers \App\Controller\TaskController::create
     * @uses \App\Controller\SecurityController::login
     */
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

    /**
     * @covers \App\Controller\TaskController::create
     * @uses \App\Form\TaskType
     */
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

    /**
     * @covers \App\Controller\TaskController::create
     * @uses \App\Form\TaskType
     */
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


    /**
     * @covers \App\Controller\TaskController::edit
     * @uses \App\Form\TaskType
     */
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

    /**
     * @covers \App\Controller\TaskController::deleteTask
     */
    public function testAdminUserCanDeleteDefaultTasks(): void
    {
        $client = $this->createClient();
        $userRepository =$this->getEntityManager()->getRepository(User::class);
        $admin = $userRepository->findOneBy(['username' => 'admin']);
        $anonymous = $userRepository->findOneBy(['username' => 'fsociety']);
        $client->loginUser($admin);
        $task = $this->getEntityManager()->getRepository(Task::class)->findOneBy(['author' => $anonymous]);
        $taskId = $task->getId();
        $client->request('GET', "/tasks/$taskId/delete");
        $this->assertResponseStatusCodeSame(303);
        $this->assertResponseRedirects('/tasks', 303);
    }

    /**
     * @covers \App\Controller\TaskController::edit
     * @uses \App\Form\TaskType
     */
    public function testAuthorCanAccessTaskEditForm(): void
    {
        $client = $this->createClient();
        $taskRepository =$this->getEntityManager()->getRepository(Task::class);
        $task = $taskRepository->find(2);
        $taskId = $task->getId();
        $author = $task->getAuthor();
        $client->loginUser($author);
        $client->request("GET", "/tasks/$taskId/edit");
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form[name="task"]');
        $this->assertSelectorExists('input[id="task_title"]');
        $this->assertSelectorExists('textarea[id="task_content"]');
        $this->assertSelectorExists('button[type="submit"]');
    }

    /**
     * @covers \App\Controller\TaskController::edit
     * @uses \App\Form\TaskType
     */
    public function testTaskCanBeEdited(): void
    {
        $client = $this->createClient();
        $taskRepository =$this->getEntityManager()->getRepository(Task::class);
        $task = $taskRepository->find(4);
        $taskId = $task->getId();
        $author = $task->getAuthor();
        $client->loginUser($author);
        $client->request("GET", "/tasks/$taskId/edit");
        $client->submitForm('Modifier', [
            'task[title]' => 'Ce titre a été changé',
            'task[content]' => 'Et cette description aussi.',
        ]);
        $taskAfterUpdate = $taskRepository->find(4);
        $this->assertNotNull($taskAfterUpdate);
        $this->assertSame($author->getEmail(), $taskAfterUpdate->getAuthor()->getEmail());
        $this->assertSame('Ce titre a été changé', $taskAfterUpdate->getTitle());
        $this->assertSame('Et cette description aussi.', $taskAfterUpdate->getContent());
        $this->assertResponseRedirects('/tasks', 303);
    }


    /**
     * @covers \App\Controller\TaskController::toggleTask
     */
    public function testUserCanToggleATask(): void
    {
        $client = $this->createClient();
        $taskRepository =$this->getEntityManager()->getRepository(Task::class);
        $task = $taskRepository->find(3);
        $taskId = $task->getId();
        $author = $task->getAuthor();
        $taskStatusBefore = $task->isDone();
        $client->loginUser($author);
        $client->request("GET", "/tasks/$taskId/toggle");
        $taskStatusAfter = $task->isDone();
        $this->assertNotSame($taskStatusBefore, $taskStatusAfter);
        $this->assertIsBool($taskStatusAfter);
        $this->assertIsBool($taskStatusBefore);
        $this->assertResponseRedirects("/tasks", 303);
    }

    /**
     * @covers \App\Controller\TaskController::deleteTask
     */
    public function testAuthorCanDeleteTheirOwnTask(): void
    {
        $client = $this->createClient();
        $taskRepository = $this->getEntityManager()->getRepository(Task::class);
        $task = $taskRepository->find(2);
        $taskId = $task->getId();
        $author = $task->getAuthor();
        $client->loginUser($author);
        $client->request("GET", "/tasks/$taskId/delete");
        $this->assertResponseStatusCodeSame(303);
        $this->assertNull($taskRepository->find(2));
    }

    /**
     * @covers \App\Controller\TaskController::deleteTask
     */
    public function testCannotDeleteTaskOfWhichUserIsNotTheAuthor(): void
    {
        $client = $this->createClient();
        $taskRepository = $this->getEntityManager()->getRepository(Task::class);
        $task = $taskRepository->find(7);
        $taskId = $task->getId();
        $author = $task->getAuthor();
        $taskWithDifferentUser = $taskRepository->createQueryBuilder("t")
            ->where('NOT t.author = :auteur')
            ->setParameter('auteur', $author)
            ->setFirstResult(1)
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();
        $differentUser = $taskWithDifferentUser[0]->getAuthor();
        $taskWithDifferentUserId = $taskWithDifferentUser[0]->getId();
        $client->loginUser($author);
        $client->request("GET", "/tasks/$taskWithDifferentUserId/delete");
        $this->assertNotSame($differentUser, $author);
        $this->assertNotSame($taskId, $taskWithDifferentUserId);
        $this->assertResponseStatusCodeSame(403);  // Forbidden
        $this->assertNotNull($taskRepository->find($taskWithDifferentUserId));
    }
}
