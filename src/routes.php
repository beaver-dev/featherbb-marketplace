<?php namespace App;

// Routes

Route::get('/', 'App\Controllers\HomeController:index')->setName('home');

Route::group('/plugins', function () {
    Route::get('', 'App\Controllers\PluginsController:find')->setName('plugins');
    Route::get('/view/{name:\w+}', 'App\Controllers\PluginsController:find')->setName('plugins.view');
    Route::map(['GET', 'POST'], '/create', 'App\Controllers\PluginsController:create')->setName('plugins.create');
    // Route::map(['GET', 'POST'], '/update', 'App\Controllers\PluginsController:update')->setName('plugins.update');
    Route::map(['GET', 'POST'], '/destroy', 'App\Controllers\PluginsController:destroy')->setName('plugins.destroy');
    Route::map(['GET', 'POST'], '/pending', 'App\Controllers\PluginsController:pending')->setName('plugins.pending');
    Route::post('/accept', 'App\Controllers\PluginsController:accept')->setName('plugins.accept');
});
