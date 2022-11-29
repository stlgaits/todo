<?php

declare(strict_types=1);

namespace App\Tests\Security\Voter;

use App\Security\Voter\TaskVoter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * @coversNothing
 */
class TaskVoterMock extends TaskVoter
{
    public function supports(string $attribute, $subject): bool
    {
        return parent::supports($attribute, $subject);
    }

    public function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        return parent::voteOnAttribute($attribute, $subject, $token);
    }
}
