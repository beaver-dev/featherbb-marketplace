<?php namespace App\Controllers;

class HomeController {

    public function index ($request, $response, $args) {
        // Render index view
        return View::addTemplate('index.php')->display();
    }

}
