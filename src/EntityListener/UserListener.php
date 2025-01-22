<?php

namespace App\EntityListener;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserListener
{
    private UserPasswordHasherInterface $hasher;
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    //Before the user is persistent we encode the password
    public function prePersist(User $user){
        $this->encodePassword($user);
    }

    //Function that takes a user as a parameter and hashes its password
     public function encodePassword(User $user){
        if ($user->getPlainPassword() === null){
            return;
        }
        $user->setPassword($this->hasher->hashPassword($user,$user->getPlainPassword()));
     }
}

