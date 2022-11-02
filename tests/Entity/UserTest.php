<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolation;

/**
 * @covers User
 */
final class UserTest extends KernelTestCase
{
    public function testItWorks(): void
    {
        self::assertEquals(42, 42);
    }

    public function testCanGetAndSetData(): void
    {
        $user = new User();
        $user->setUsername('michel');
        $user->setPassword('mynameismichelandthisismypassword');
        $user->setEmail('michel.vaillant@laposte.net');
        $user->setRoles(['ROLE_FAST_LIFE']);
        $this->assertSame('michel', $user->getUsername());
        $this->assertSame('michel.vaillant@laposte.net', $user->getEmail());
        $this->assertContains('ROLE_FAST_LIFE', $user->getRoles(), 'A role is missing from the user\'s list of roles');
        $this->validateUser($user);
    }
    

    /**
     * Ensures created User matches validation constraints
     */
    public function validateUser(User $user): void
    {
        self::bootKernel();
        $errors = $this->getContainer()->get('validator')->validate($user);
        $validationErrors = [];
        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $validationErrors[] = $error->getPropertyPath() . ' ' . $error->getMessage();
        }
        $this->assertCount(0, $errors, implode(',', $validationErrors));
        $this->assertInstanceOf(User::class, $user);
    }
}
