<?php

namespace App\Tests\Security\Voter;

use App\Entity\Task;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Security\Voter\TaskVoter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;

/**
 * @covers TaskVoter
 */
class TaskVoterTest extends WebTestCase
{
    /**
     * @covers TaskVoter::voteOnAttribute
     * @throws \Exception
     */
    public function testGrantTaskDeleteAccessToAdminUserAndTaskAuthorIsAnonymous(): void
    {
        $this->markTestIncomplete();
        $client = $this->createClient();
        $security =  static::getContainer()->get(Security::class);
//        $taskVoter = static::getContainer()->get(TaskVoter::class);
//        $taskVoter = $this->createMock(TaskVoterMock::class)
//            ->expects(self::once())
//            ->method('supports')
//            ->willReturn(true)
//        ;
        // @TODO: I can't find how to generate the voter properly
        $taskVoter = new TaskVoterMock($security);
        $userRepository = static::getContainer()->get(UserRepository::class);
        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $admin = $userRepository->findOneBy(['username' => 'admin']);
        $client->loginUser($admin);
        $anonymousTasks = $taskRepository->findBy(['author' => 'fsociety']);
        $token = $this->createMock(TokenInterface::class)
            ->expects(self::once())
            ->method('getUser')
            ->willReturn($admin);
        $vote = $taskVoter->voteOnAttribute('TASK_DELETE', $anonymousTasks[0], $token);
        $this->assertInstanceOf(Task::class, $anonymousTasks[0]);
        $this->assertTrue($vote);
    }

    /**
     * @covers TaskVoter::voteOnAttribute
     */
    public function testGrantTaskDeleteAccessToTaskAuthor(): void
    {
        $this->markTestIncomplete();
        $client = $this->createClient();
    }

    /**
     * @covers TaskVoter::voteOnAttribute
     */
    public function testDoNotVoteOnUnsupportedCases(): void
    {
        $this->markTestIncomplete();
        $client = $this->createClient();
        // this attribute doesn't exist in our codebase
        $attribute = "TASK_MODIFY";
        $this->expectException((sprintf('Unhandled attribute "%s"', $attribute)));
    }
}
