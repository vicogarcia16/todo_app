<?php

namespace App;

class Config
{
    public static function get(string $key, $default = null)
    {
        if (!isset($_ENV[$key])) {
            if ($default !== null) {
                return $default;
            }
            throw new \Exception("Enviroment variable '{$key}' is not set.");
        }

        return $_ENV[$key];
    }
}
