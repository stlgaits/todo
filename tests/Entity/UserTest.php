<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use App\Test\CustomTestCase;
use Symfony\Component\Validator\ConstraintViolation;

/**
 * @group security
 * @covers App\Entity\User
 */
final class UserTest extends CustomTestCase
{
    /**
     * @coversNothing
     */
    public function testItWorks(): void
    {
        self::assertEquals(42, 42);
    }

    /**
     * @covers \App\Entity\User::setUsername
     * @covers \App\Entity\User::setPassword
     * @covers \App\Entity\User::setEmail
     * @covers \App\Entity\User::setRoles
     * @uses   \App\Entity\Task
     */
    public function testCanGetAndSetData(): void
    {
        $em = $this->getEntityManager();
        $user = new User();
        $user->setUsername('michel');
        $user->setPassword('mynameismichelandthisismypassword');
        $user->setEmail('michel.vaillant@laposte.net');
        $user->setRoles(['ROLE_FAST_LIFE']);
        $em->persist($user);
        for ($i = 0; $i < 5; $i++) {
            $task = $this->createTask(
                sprintf('task %s', $i),
                sprintf('This is task number %s & it requires me to do stuff', $i),
                $user
            );
            $user->addTask($task);
        }
        // remove last task
        $tasks = $user->getTasks();
        $userWithOneLessTask = $user->removeTask($tasks[4]);
        $this->assertIsInt($user->getId());
        $this->assertSame('michel', $user->getUsername());
        $this->assertSame($user->getUsername(), $user->getUserIdentifier());
        $this->assertSame($user->getUsername(), $user->__toString());
        $this->assertSame('michel.vaillant@laposte.net', $user->getEmail());
        $this->assertSame('mynameismichelandthisismypassword', $user->getPassword());
        $this->assertArrayNotHasKey('ROLE_ADMIN', $user->getRoles());
        $this->assertArrayNotHasKey('ROLE_DISABLED', $user->getRoles());
        $this->assertContains('ROLE_FAST_LIFE', $user->getRoles(), 'A role is missing from the user\'s list of roles');
        $this->assertNotNull($user->getTasks());
        $this->assertInstanceOf(Task::class, $user->getTasks()[0]);
        $this->assertInstanceOf(User::class, $userWithOneLessTask);
        $this->assertIsIterable($tasks);
        $this->assertCount(4, $user->getTasks());
        $this->assertArrayNotHasKey(4, $user->getTasks());
        $this->validateUser($user, true);
    }

    /**
     * @dataProvider invalidEmailProvider
     * @covers       \App\Entity\User::setEmail
     */
    public function testEmailValidation(string $email): void
    {
        $user = $this->createUser('francis', 'testspwd', $email);
        $this->validateUser($user, false);
    }


    public function invalidEmailProvider(): array
    {
        return [
            ['test'],
            ['test@email'],
            ['@test.com'],
            ['test email'],
            ['1'],
            ['1@1.']
        ];
    }

    /**
     * Ensures created User matches validation constraints
     */
    public function validateUser(User $user, bool $expectPassingValidation): void
    {
        self::bootKernel();
        $errors = $this->getContainer()->get('validator')->validate($user);
        $validationErrors = [];
        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $validationErrors[] = $error->getPropertyPath() . ' ' . $error->getMessage();
        }
        if ($expectPassingValidation) {
            $this->assertCount(0, $errors, implode(',', $validationErrors));
        } else {
            $this->assertNotNull($validationErrors);
            $this->assertTrue((0 < count($validationErrors)));
        }
        $this->assertInstanceOf(User::class, $user);
    }
}
