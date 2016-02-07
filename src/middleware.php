<?php namespace App;

use ORM;

// Application middlewares


// CSRF protection
App::add(new \App\Middleware\Csrf);
// App::add(new \App\Middleware\Core);

// Init database
App::add(function($req, $res, $next) {
    $settings = Config::get('database');
    ORM::configure('mysql:host='.$settings['host'].';dbname='.$settings['dbname']);
    ORM::configure('username', $settings['username']);
    ORM::configure('password', $settings['password']);
    ORM::configure('logging', true);
    // Model::$auto_prefix_models = '\\'.$settings['prefix'].'\\';
    return $next($req, $res);
});

// Load plugins hooks
App::add(function($req, $res, $next) {
    $pluginClasses = [
        '\App\Test'
    ];
    foreach ($pluginClasses as $pluginClass) {
        $plugin = new $pluginClass();
        // Check if plugin implements default plugins structure
        if (!$plugin instanceof \App\Core\PluginInterface) {
            $warning = [
                'pluginClass' => $pluginClass,
                'message' => 'All plugins must implement "App\Core\PluginInterface".'
            ];
            Container::get('hooks')->fire('plugin.warning', $warning);
        }
        else {
            Container::get('hooks')->fire('plugin.launch', $pluginClass);
            $plugin->attachEvents();
        }
    }

    return $next($req, $res);
});
