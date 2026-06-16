<?php

namespace App\Helpers;

class Session
{
    public static function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key)
    {
        return $_SESSION[$key] ?? null;
    }

    public static function has($key): bool
    {
        return isset($_SESSION[$key]);
    }

    public static function destroy()
    {
        $_SESSION = [];
        session_destroy();
    }
}