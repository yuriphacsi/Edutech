<?php

namespace App\Helpers;

class Mask
{
    public static function email(string $email): string
    {
        $parts = explode('@', $email);

        $name = $parts[0];
        $domain = $parts[1];

        return substr($name, 0, 2) . '****@' . $domain;
    }

    public static function name(string $text): string
    {
        return substr($text, 0, 1) . str_repeat('*', max(strlen($text) - 1, 1));
    }
}