<?php

namespace App\Security\Voter;

use App\Entity\Task;
use Exception;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class TaskVoter extends Voter
{
    public const DELETE = 'TASK_DELETE';

    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        return $attribute == self::DELETE
            && $subject instanceof Task;
    }

    /**
     * @throws Exception
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        /** @var Task $subject */

        if ($attribute == self::DELETE) {
            // User can delete their own tasks
            if ($user === $subject->getAuthor()) {
                return true;
            }
            // Admin Users can delete tasks that are attributed to the "Anonymous" User (fixtures)
            if ($this->security->isGranted('ROLE_ADMIN') && $subject->getAuthor()->getUsername() === 'fsociety') {
                return true;
            }
            return false;
        }

        throw new Exception(sprintf('Unhandled attribute "%s"', $attribute));
    }
}
