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
        $task = $this->createTaskObject();
        $task->setTitle($title);
        $this->assertSame($title, $task->getTitle());
    }

    /**
     * @dataProvider contentProvider
     */
    public function testTaskShouldHaveADescription(string $content): void
    {
        $task = $this->createTaskObject();
        $task->setContent($content);
        $this->assertSame($content, $task->getContent());
    }

    public function testATaskShouldHaveAnAuthor(): void
    {
        $task = $this->createTaskObject();
        $this->assertNotNull($task);
        $this->validateTask($task);
        $this->assertNotNull($task->getAuthor());
//        $this->markTestIncomplete();
    }

    public function testDefaultTasksShouldBeAssignedToAnonymousUser(): void
    {
        $this->markTestIncomplete();
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
}
