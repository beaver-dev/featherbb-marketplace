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

// user
// Container::set('user', function ($c){
//     $user = new \App\Middleware\Auth(Request::getHeaders());
//     if ($user->isLogged()) {
//         # code...
//     }
//     return $user;
// });
