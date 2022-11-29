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
     */
    public function testCanGetAndSetData(Task $task): void
    {
        $user = new User();
        $user->setUsername('michel');
        $user->setPassword('mynameismichelandthisismypassword');
        $user->setEmail('michel.vaillant@laposte.net');
        $user->setRoles(['ROLE_FAST_LIFE']);
        for ($i = 0 ; $i < 5; $i++) {
            $task = $this->createTask(
                sprintf('task %s', $i),
                sprintf('This is task number %s & it requires me to do stuff', $i),
                $user
            );
            $user->addTask($task);
        }
        $this->assertSame('michel', $user->getUsername());
        $this->assertSame('michel.vaillant@laposte.net', $user->getEmail());
        $this->assertContains('ROLE_FAST_LIFE', $user->getRoles(), 'A role is missing from the user\'s list of roles');
        $this->validateUser($user, true);
    }

    /**
     * @dataProvider invalidEmailProvider
     * @covers \App\Entity\User::setEmail
     */
    public function testEmailValidation(string $email): void
    {
        $user = $this->createUser('francis', 'testspwd', $email);
        $this->validateUser($user, false);
    }

//
//    public function taskProvider(): array
//    {
//        $tasks = [];
//        for ($i = 0 ; $i < 5; $i++) {
//            $task = $this->createTask(
//                sprintf('task %s', $i),
//                sprintf('This is task number %s & it requires me to do stuff', $i),
//            );
//            $tasks[$i] = $task;
//        }
//        return [
//            $tasks
//        ];
//    }

//    public function testCanAssignTaskToUser(): void
//    {
//
//    }
//
//    public function testCanGetTaskList(): void
//    {
//
//    }

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
