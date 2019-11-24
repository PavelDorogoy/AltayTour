<?php

namespace App\Security;

use App\Entity\User as AppUser;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        // TODO: Implement checkPreAuth() method.
    }

    public function checkPostAuth(UserInterface $user)
    {
        // TODO: Implement checkPostAuth() method.
        if ($user instanceof AppUser) {
            if (!$user->getIsConfirmed()) {
                throw new CustomUserMessageAuthenticationException(
                    'Подтвердите ваш e-mail, пройдя по ссылке, отправленной вам в письме.'
                );
            }
        }
    }
}