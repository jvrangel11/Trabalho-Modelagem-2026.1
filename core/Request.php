<?php

namespace App\Core;

class Request
{
      public static function uri()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // remove a pasta do projeto
        $uri = str_replace('/TrabalhoModelagem_SistemaPousadaPedraTalhada', '', $uri);

        return trim($uri, '/');
    }

    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}