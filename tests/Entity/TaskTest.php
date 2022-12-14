<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use App\Test\CustomTestCase;
use DateTime;
use Doctrine\DBAL\Exception\NotNullConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Provider\Lorem;
use Symfony\Component\Validator\ConstraintViolation;

/**
 * @group task
 * @covers \App\Entity\Task
 * @uses   \App\Entity\User
 */
final class TaskTest extends CustomTestCase
{
    /**
     * @coversNothing
     */
    public function testItWorks(): void
    {
        self::assertEquals(42, 42);
    }

    /**
     * @covers \App\Entity\Task::setTitle
     * @covers \App\Entity\Task::isDone
     * @covers \App\Entity\Task::setCreatedAt
     * @covers \App\Entity\Task::setContent
     */
    public function testCanGetAndSetData(): void
    {
        $em = $this->getEntityManager();
        $task = new Task();
        $task->setTitle("Faire la vaisselle");
        $task->setContent("Laver les planches en bois à la main et mettre le reste dans le lave-vaisselle, puis le vider");
        $task->isDone(false);
        $task->setCreatedAt(new DateTime());
        $user = new User();
        $user->setUsername('mark');
        $user->setPassword('markpwd123456');
        $user->setEmail('mark@gmail.com');
        $task->setAuthor($user);
        $em->persist($user);
        $em->persist($task);
        $em->flush();
        $this->assertIsInt($task->getId());
        $this->assertSame('Faire la vaisselle', $task->getTitle());
        $this->assertSame('Laver les planches en bois à la main et mettre le reste dans le lave-vaisselle, puis le vider', $task->getContent());
        $this->assertSame(false, $task->isDone());
        $this->assertSame($task->getTitle(), $task->__toString());
        $this->assertSame($user, $task->getAuthor());
        $this->assertInstanceOf(User::class, $task->getAuthor());
        $this->assertLessThanOrEqual(new DateTime(), $task->getCreatedAt());
        $this->validateTask($task);
    }

    /**
     * @covers \App\Entity\Task::setTitle
     * @covers \App\Entity\Task::setContent
     * @covers \App\Entity\Task::setCreatedAt
     * @covers \App\Entity\Task::toggle
     */
    public function testCanToggleATask(): void
    {
        $task = new Task();
        $task->setTitle("Faire la vaisselle");
        $task->toggle(true);
        $task->setCreatedAt(new DateTime());
        $task->setContent("Laver les planches en bois à la main et mettre le reste dans le lave-vaisselle, puis le vider");
        $this->assertSame(true, $task->isDone(), 'The task isDone status should be toggled to true');
    }

    /**
     * @dataProvider titleProvider
     * @covers       \App\Entity\Task::setTitle
     */
    public function testTaskShouldHaveATitleString(string $title): void
    {
        $task = $this->createTaskObject();
        $task->setTitle($title);
        $this->assertSame($title, $task->getTitle());
    }

    /**
     * @dataProvider contentProvider
     * @covers       \App\Entity\Task::setContent
     */
    public function testTaskShouldHaveADescription(string $content): void
    {
        $task = $this->createTaskObject();
        $task->setContent($content);
        $this->assertSame($content, $task->getContent());
    }

    /**
     * @covers \App\Entity\Task::setAuthor
     */
    public function testATaskShouldHaveAnAuthor(): void
    {
        $em = $this->getEntityManager();

        $task = $this->createTaskObject();
        $author = $this->createUser("awesomeauthor", "thisisnotreallymypassword", "awesomeauthor@yahoo.com");
        $task->setAuthor($author);
        $this->validateTask($task);
        $em->persist($author);
        $em->persist($task);
        $em->flush();
        $this->assertNotNull($task);
        $this->assertNotNull($task->getAuthor());
        $this->assertSame($author, $task->getAuthor());
    }


    /**
     * @covers \App\Entity\Task::setAuthor
     */
    public function testCannotCreateTaskWithoutAuthor(): void
    {
        $this->expectException(NotNullConstraintViolationException::class);
        $em = $this->getEntityManager();
        $task = $this->createTaskObject();
        $this->validateTask($task);
        $em->persist($task);
        $em->flush();
    }

    /**
     * Ensures created Task matches validation constraints
     */
    public function validateTask(Task $task): void
    {
        self::bootKernel();
        $errors = $this->getContainer()->get('validator')->validate($task);
        $validationErrors = [];
        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $validationErrors[] = $error->getPropertyPath() . ' ' . $error->getMessage();
        }
        $this->assertCount(0, $errors, implode(',', $validationErrors));
        $this->assertInstanceOf(Task::class, $task);
    }


    public function titleProvider(): \Generator
    {
        yield ["Faire la vaisselle"];
        yield ["Ranger ma chambre"];
        yield ["Payer la facture d'électricité"];
        yield [Lorem::sentence()];
    }

    public function contentProvider(): \Generator
    {
        yield ["Faire la vaisselle"];
        yield ["Ranger ma chambre"];
        yield ["Payer la facture d'électricité"];
        yield [Lorem::paragraph()];
    }


    public function createTaskObject(): Task
    {
        $task = new Task();
        $task->setTitle("This is a test task");
        $task->setContent("I mean, I could write anything here, right?");
        $task->isDone(false);
        $this->validateTask($task);
        return $task;
    }

    /*
     * @throws Exception
     */
    protected function getEntityManager(): EntityManagerInterface
    {
        return static::getContainer()->get('doctrine')->getManager();
    }
}
