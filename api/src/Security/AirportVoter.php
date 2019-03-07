<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\Airport;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class AirportVoter extends Voter
{
    const EDIT = 'edit';

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [self::EDIT])) {
            return false;
        }

        if (!$subject instanceof Airport) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        /** @var Airport $airport */
        $airport = $subject;

        if ($attribute == self::EDIT) {
            return $this->canEdit($subject, $user);
        }

        return false;
    }

    private function canEdit(Airport $airport, User $user): bool
    {
        return $airport->getManager()->getId() === $user->getId();
    }
}
