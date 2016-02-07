<?php namespace App\Controllers;

class UserController {

    public function index($res, $res, $args) {
        // Render index view
        return $this->renderer->render($res, 'index.html', $args);
    }

    public function login($req, $res, $args)
    {
        # code...
    }

}
