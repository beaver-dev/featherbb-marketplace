<?php namespace App\Middleware;

/**
 * Core middleware
 */
class Core
{

    function __invoke($req, $res, $next)
    {
        
        var_dump($req->getAttributes());
        // View::setPageInfo(['okok'=>$pair[$this->prefix . '_value']]);
        return $next($req, $res);
    }
}
