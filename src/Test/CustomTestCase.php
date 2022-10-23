<?php

declare(strict_types=1);

namespace App\Test;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CustomTestCase extends WebTestCase
{
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

    protected function createAdminUser(): User
    {
        $user = new User();
        return $user;
    }

    protected function createTask(): Task
    {
        $task = new Task();
        return $task;
    }

    protected function toggleTask(): void
    {
    }

    protected function deleteTask(): void
    {
    }

    protected function login(): void
    {
    }

    protected function logout(): void
    {
    }
}
