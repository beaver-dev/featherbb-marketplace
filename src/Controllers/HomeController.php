<?php namespace App\Controllers;

class HomeController extends BaseController {

    public function index ($request, $response, $args) {
        // Render index view
        return View::setPageInfo(['active_nav' => 'index'])->addTemplate('index.php')->display();
    }

}
