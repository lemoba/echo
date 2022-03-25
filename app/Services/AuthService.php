<?php declare(strict_types=1);

namespace App\Services;

use App\Model\User;

class AuthService
{
    public static function getUserByEmail($email)
    {
        return User::query()->where('email', $email)->first();
    }
}