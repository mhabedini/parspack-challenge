<?php

namespace App\Services;

use App\Models\User;

class AuthService
{
    private const TOKEN_NAME = '';

    public function loginWithUsername(string $username): string
    {
        $user = User::whereUsername($username)->first();
        return $this->createToken($user);
    }

    public function loginWithEmail(string $email): string
    {
        $user = User::whereEmail($email)->first();
        return $this->createToken($user);
    }

    public function signup(array $userData): User
    {
        return User::create($userData);
    }

    public function createToken(User $user): string
    {
        return $user->createToken(self::TOKEN_NAME)->accessToken;
    }
}
