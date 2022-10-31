<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Task;
use DateTime;
use Faker\Provider\Lorem;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolation;

/**
 * @covers Task
 */
class TaskTest extends KernelTestCase
{
    public function testItWorks(): void
    {
        self::assertEquals(42, 42);
    }

    public function testCanGetAndSetData(): void
    {
        $task = new Task();
        $task->setTitle("Faire la vaisselle");
        $task->isDone(false);
        $task->setCreatedAt(new DateTime());
        $task->setContent("Laver les planches en bois à la main et mettre le reste dans le lave-vaisselle, puis le vider");
        $this->assertSame('Faire la vaisselle', $task->getTitle());
        $this->assertSame('Laver les planches en bois à la main et mettre le reste dans le lave-vaisselle, puis le vider', $task->getContent());
        $this->assertSame(false, $task->isDone());
    }

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
     */
    public function testTaskShouldHaveATitleString(string $title): void
    {
        $task = new Task();
        $task->setTitle($title);
        $this->assertSame($title, $task->getTitle());
    }

    public function testTaskShouldHaveADescription(): void
    {
        $this->markTestIncomplete();
    }

    public function testATaskShouldHaveAnAuthor(): void
    {

        $this->markTestIncomplete();
    }

    public function testDefaultTasksShouldBeAssignedToAnonymousUser(): void
    {
        $this->markTestIncomplete();
    }

    /**
     * Ensures created Task matches validation constraints
     */
    public function validateTask(Task $task, int $number = 0): void
    {
        self::bootKernel();
        $errors = $this->getContainer()->get('validator')->validate($task);

        $errorsMessages = [];
        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $errorsMessages[] = $error->getPropertyPath() . ' => ' . $error->getMessage();
        }

        $this->assertCount($number, $errors, implode(',', $errorsMessages));
    }


    public function titleProvider(): \Generator
    {
        yield ["Faire la vaisselle"];
        yield ["Ranger ma chambre"];
        yield ["Payer la facture d'électricité"];
        yield [Lorem::sentence()];
    }


    public function createTaskObject(): Task
    {
        $task = new Task();
        $task->setTitle("This is a test task");
        $task->setContent("I mean, I could write anything here, right?");
        $task->isDone(false);
        return $task;
    }
}
