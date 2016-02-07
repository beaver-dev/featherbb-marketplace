<?php namespace App\Core\Interfaces;

class Router extends SlimSugar
{

    public static function pathFor($name, array $data = [], array $queryParams = [])
    {
        return Container::get('router')->pathFor($name, $data, $queryParams);
    }

    public static function redirect($uri)
    {
        return Response::withStatus(301)->withHeader('Location', $uri);
    }

}
