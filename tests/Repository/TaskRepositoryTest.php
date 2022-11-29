<?php

namespace App\Tests\Repository;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @group task
 * @covers \App\Repository\TaskRepository
 */
class TaskRepositoryTest extends KernelTestCase
{
    /**
     * @covers \App\Repository\TaskRepository::orderByStatus
     * @uses App\Entity\Task::isDone
     */
    public function testOrderByStatus(): void
    {
        $kernel = self::bootKernel();
        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $tasks = $taskRepository->orderByStatus();
        $lastTask = end($tasks);
        $this->assertSame('test', $kernel->getEnvironment());
        $this->assertNotNull($tasks);
        $this->assertInstanceOf(Task::class, $tasks[0]);
        $this->assertInstanceOf(Task::class, $lastTask);
        $this->assertSame(false, $tasks[0]->isDone());
        $this->assertSame(true, $lastTask->isDone());
        // @TODO: how can we test that this isn't just a luck random result
        // How could we split that array & actually check it's ordered by isDone()?
        // $this->markTestIncomplete();
    }
}
