<?php namespace App;

// DIC configuration

// view renderer
Container::set('renderer', function ($c) {
    return new \App\Core\View;
});

// hooks
Container::set('hooks', function($c) {
    return new \App\Core\Hooks;
});

// cookies
Container::set('cookie', function($c){
    $request = $c->get('request');
    return new \Slim\Http\Cookies($request->getCookieParams());
});
