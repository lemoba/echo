<?php declare(strict_types=1);

namespace App\Utils;

class PasswordUtil
{
    public static function make(string $password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function verify(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    public static function genToken(int $len = 10): string
    {
        $time = (string)time();
        $str = md5($time);
        return substr($str, 0, $len);
    }
}