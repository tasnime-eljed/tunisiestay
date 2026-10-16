<?php
// src/Security/LogementVoter.php

namespace App\Security;

use App\Entity\Logement;
use App\Entity\Utilisateur;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class LogementVoter extends Voter
{
    protected function supports(string $attribute, mixed $subject): bool
    {
        return $attribute === 'LOGEMENT_EDIT' && $subject instanceof Logement;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof Utilisateur)
            return false;

        return $subject->getProprietaire() === $user;
    }
}