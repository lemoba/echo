<?php declare(strict_types=1);

namespace App\Triats;

trait Singleton
{
    private static $instance;

    public static function getInstance(...$args)
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new static(...$args);
        }
        return self::$instance;
    }
}