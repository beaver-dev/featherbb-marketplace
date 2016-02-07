<?php namespace App\Controllers;

class HomeController {

    public function index ($request, $response, $args) {
        // \Config::set('displayErrorDetails', true);
        // echo \Config::get('displayErrorDetails') ? 'oui' : 'non';
        // echo Request::getHeader('HTTP_USER_AGENT', 'ok')[0];
        // var_dump(\Response::getStatusCode());
        // var_dump($request->getAttribute('csrf_name', 'de'));
        // var_dump(Request::getAttributes());
        // $de = \App\Core\Interfaces\Route::pathFor('oj');
        // var_dump($de);
        // $de = \Router::pathFor('plugins', ['name'=>'ok']);
        // return Router::redirect('/ok');
        // return $response->withStatus(301)->withHeader('Location', 'ok');
        // var_dump(\Container::get('environment'));
        // var_dump($request->getAttribute('csrf_name'));
        // Render index view
        return View::setPageInfo(['users' => 'oksss'])->addTemplate('index.php')->display();
    }

}
