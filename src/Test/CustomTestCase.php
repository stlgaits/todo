<?php

declare(strict_types=1);

namespace App\Test;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CustomTestCase extends WebTestCase
{
    use RefreshDatabaseTrait;

    /*
    * @throws Exception
    */
    protected function getEntityManager(): EntityManagerInterface
    {
        return static::getContainer()->get('doctrine')->getManager();
    }

    protected function createUser(string $username, string $password, string $email): User
    {
        $container = static::getContainer();
        $em = $this->getEntityManager();

        $user = new User();
        $user->setEmail($email);
        $user->setUsername($username);
        $encoded = $container->get('security.password_hasher')->hashPassword($user, $password);
        $user->setPassword($encoded);

        $em->persist($user);
        $em->flush();

        return $user;
    }

    protected function createAdminUser(string $username, string $password, string $email): User
    {
        $em = $this->getEntityManager();
        $user = $this->createUser($username, $password, $email);
        $user->setRoles(['ROLE_ADMIN']);
        $em->persist($user);
        $em->flush();

        return $user;
    }

    protected function createTask(): Task
    {
        $task = new Task();
        return $task;
    }

    protected function toggleTask(Task $task, bool $done): void
    {
        $em = $this->getEntityManager();
        $task->isDone($done);
        $em->persist($task);
        $em->flush();
    }

    protected function deleteTask(Task $task): void
    {
        $em = $this->getEntityManager();
        $em->remove($task);
        $em->flush();
    }

    protected function login(User $user): void
    {
        $client = static::createClient();
        $client->loginUser($user);
    }

    protected function logout(): void
    {
    }
}
