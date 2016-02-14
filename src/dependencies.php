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

// flash messages
Container::set('flash', function($c) {
    return new \Slim\Flash\Messages;
});

// cookies
Container::set('cookie', function($c){
    $request = $c->get('request');
    return new \Slim\Http\Cookies($request->getCookieParams());
});
