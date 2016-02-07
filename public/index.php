<?php

use Slim;
use App\Core\Interfaces\SlimStatic;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $file = __DIR__ . $_SERVER['REQUEST_URI'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

session_start();

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new Slim\App($settings);
SlimStatic::boot($app);
// Allow static proxies to be called from anywhere in App
Statical::addNamespace('*', 'App\\*', 'App\\Controllers\\*', 'App\\Models\\*', 'App\\Middleware\\*', 'App\\Plugins\\*');

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';
// Register middleware
require __DIR__ . '/../src/middleware.php';
// Register routes
require __DIR__ . '/../src/routes.php';

// Run app
App::run();
