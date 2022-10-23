<?php

declare(strict_types=1);

namespace App\Tests\Unit\Entity;

use App\Entity\Task;
use DateTime;
use Faker\Provider\Lorem;
use PHPUnit\Framework\TestCase;

/**
 * @covers Task
 */
class TaskTest extends  TestCase
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

//    /**
//     * @dataProvider invalidTitleProvider
//     */
//    public function testTaskShouldHaveAValidTitle($title): void
//    {
//        $task = new Task();
//        $task->setTitle($title);
//        $this->expectError();
//    }

    public function testTaskShouldHaveADescription(): void
    {
        $this->markTestIncomplete();
    }

    public function titleProvider(): \Generator
    {
        yield ["Faire la vaisselle"];
        yield ["Ranger ma chambre"];
        yield ["Payer la facture d'électricité"];
        yield [Lorem::sentence()];

    }

//    public function invalidTitleProvider(): \Generator
//    {
//        yield [1];
//        yield [9930];
//        yield ["A"];
//        yield ["1"];
//        yield [null];
//        yield [0];
//        yield [Lorem::text()];
//        yield [""];
//        yield [[]];
//        yield [["Faire la vaisselle"]];
//        yield [";"];
//        yield ["@"];
//    }
}