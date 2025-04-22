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
            throw new \Exception("La variable de entorno '{$key}' no está definida.");
        }

        return $_ENV[$key];
    }
}
