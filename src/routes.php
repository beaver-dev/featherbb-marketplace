<?php namespace App;

// Routes

Route::get('/', 'App\Controllers\HomeController:index')->setName('home');

Route::group('/plugins', function () {
    Route::get('[/page-{page:\d+}]', 'App\Controllers\PluginsController:index')->setName('plugins');
    Route::get('/view/{name:[\w\-]+}[/{action:\w+}]', 'App\Controllers\PluginsController:view')->setName('plugins.view');
    Route::get('/download/{name:[\w\-]+}[/{version}]', 'App\Controllers\PluginsController:download')->setName('plugins.download');

    Route::map(['GET', 'POST'], '/create', 'App\Controllers\PluginsController:create')->setName('plugins.create');
    Route::map(['GET', 'POST'], '/pending', 'App\Controllers\PluginsController:pending')->setName('plugins.pending');
    Route::post('/accept', 'App\Controllers\PluginsController:accept')->setName('plugins.accept');
    Route::get('/update/{name:[\w\-]+}', 'App\Controllers\PluginsController:update')->setName('plugins.update');

    Route::get('/tags/{tag:[\w\-]+}[/page-{page:\d+}]', 'App\Controllers\PluginsController:tags')->setName('plugins.tags');
    Route::get('/search[/page-{page:\d+}]', 'App\Controllers\PluginsController:search')->setName('plugins.search');
    Route::get('/author/{author:[\w\-]+}[/page-{page:\d+}]', 'App\Controllers\PluginsController:author')->setName('plugins.author');

    // Route::map(['GET', 'POST'], '/update', 'App\Controllers\PluginsController:update')->setName('plugins.update');
    // Route::map(['GET', 'POST'], '/destroy', 'App\Controllers\PluginsController:destroy')->setName('plugins.destroy');
});

Route::group('/themes', function () {
    Route::get('[/page-{page:\d+}]', 'App\Controllers\ThemesController:index')->setName('themes');
    Route::get('/view/{name:[\w\-]+}', 'App\Controllers\ThemesController:view')->setName('themes.view');
    Route::get('/download/{name:[\w\-]+}', 'App\Controllers\ThemesController:download')->setName('themes.download');

    Route::map(['GET', 'POST'], '/create', 'App\Controllers\ThemesController:create')->setName('themes.create');
    Route::map(['GET', 'POST'], '/pending', 'App\Controllers\ThemesController:pending')->setName('themes.pending');
    Route::post('/accept', 'App\Controllers\ThemesController:accept')->setName('themes.accept');
    Route::get('/update/{name:[\w\-]+}', 'App\Controllers\ThemesController:update')->setName('themes.update');

    Route::get('/tags/{tag:[\w\-]+}[/page-{page:\d+}]', 'App\Controllers\ThemesController:tags')->setName('themes.tags');
    Route::get('/search[/page-{page:\d+}]', 'App\Controllers\ThemesController:search')->setName('themes.search');
    Route::get('/author/{author:[\w\-]+}[/page-{page:\d+}]', 'App\Controllers\ThemesController:author')->setName('themes.author');

    // Route::map(['GET', 'POST'], '/update', 'App\Controllers\PluginsController:update')->setName('themes.update');
});

Route::group('/auth', function() {
    Route::map(['GET', 'POST'], '', 'App\Controllers\AuthController:login')->setName('login');
    Route::get('/logout', 'App\Controllers\AuthController:logout')->setName('logout');
});
