<?php namespace App;

// Routes

Route::get('/', 'App\Controllers\HomeController:index')->setName('home');

Route::group('/plugins', function () {
    Route::get('', 'App\Controllers\PluginsController:index')->setName('plugins');
    Route::get('/view/{name:[\w\-]+}[/{action:\w+}]', 'App\Controllers\PluginsController:view')->setName('plugins.view');
    Route::get('/download/{name:[\w\-]+}[/{version}]', 'App\Controllers\PluginsController:download')->setName('plugins.download');

    Route::map(['GET', 'POST'], '/create', 'App\Controllers\PluginsController:create')->setName('plugins.create');
    Route::map(['GET', 'POST'], '/pending', 'App\Controllers\PluginsController:pending')->setName('plugins.pending');
    Route::post('/accept', 'App\Controllers\PluginsController:accept')->setName('plugins.accept');

    Route::get('/tags/{tag}', 'App\Controllers\PluginsController:tags')->setName('plugins.tags');
    Route::get('/search', 'App\Controllers\PluginsController:search')->setName('plugins.search');
    Route::get('/author/{author}', 'App\Controllers\PluginsController:author')->setName('plugins.author');

    // Route::map(['GET', 'POST'], '/update', 'App\Controllers\PluginsController:update')->setName('plugins.update');
    // Route::map(['GET', 'POST'], '/destroy', 'App\Controllers\PluginsController:destroy')->setName('plugins.destroy');
});
