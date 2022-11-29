<?php

namespace App\Tests\Security\Voter;

use App\Entity\Task;
use App\Entity\User;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use App\Test\CustomTestCase;
use App\Security\Voter\TaskVoter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;

class TaskVoterTest extends CustomTestCase
{
    /**
     * @covers TaskVoter::voteOnAttribute
     * @throws \Exception
     */
    public function testGrantTaskDeleteAccessToAdminUserAndTaskAuthorIsAnonymous(): void
    {
        $client = $this->createClient();
//        $security =  static::getContainer()->get(Security::class);
        $security =  $this->createMock(Security::class);

//        $taskVoter = static::getContainer()->get(TaskVoter::class);
//        $taskVoter = $this->createMock(TaskVoterMock::class)
//            ->expects(self::once())
//            ->method('supports')
//            ->willReturn(true)
//        ;
        $userRepository = static::getContainer()->get(UserRepository::class);
        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $admin = $userRepository->findOneBy(['username' => 'admin']);
        $anonymousUser = $userRepository->findByUsername('fsociety');
        $anonymousTasks = $taskRepository->findBy(['author' => $anonymousUser]);
        $client->loginUser($admin);
        $taskVoter = new TaskVoterMock($security);
        // @TODO: I can't find how to generate the token properly
        // TypeError: App\Tests\Security\Voter\TaskVoterMock::voteOnAttribute(): Argument #3 ($token) must be of type Symfony\Component\Security\Core\Authentication\Token\TokenInterface, PHPUnit\Framework\MockObject\Builder\InvocationMocker given
//        $token = $this->createMock(TokenInterface::class)
//            ->expects(self::once())
//            ->method('setUser')
//            ->with($admin)
////            ->willReturn($admin)
//        ;
//        $vote = $taskVoter->voteOnAttribute('TASK_DELETE', $anonymousTasks[0], $token);
//        $vote = $taskVoter->voteOnAttribute('TASK_DELETE', $anonymousTasks[0], );
        $this->assertIsArray($anonymousTasks);
        $this->assertInstanceOf(Task::class, $anonymousTasks[0]);
        $this->assertInstanceOf(User::class, $admin);
        $this->assertContains('ROLE_ADMIN', $admin->getRoles());
//        $this->assertTrue($vote);
    }

    /**
     * @covers TaskVoter::voteOnAttribute
     */
    public function testGrantTaskDeleteAccessToTaskAuthor(): void
    {
        $this->markTestIncomplete();
        $client = $this->createClient();
    }

//    /**
//     * @covers TaskVoter::voteOnAttribute
//     */
//    public function testDoNotVoteOnUnsupportedCases(): void
//    {
//        $this->markTestIncomplete();
//        $client = $this->createClient();
//        // this attribute doesn't exist in our codebase
//        $attribute = "TASK_MODIFY";
//        $this->expectException((sprintf('Unhandled attribute "%s"', $attribute)));
//    }
}
