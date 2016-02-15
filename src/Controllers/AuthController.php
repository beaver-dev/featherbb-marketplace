<?php namespace App\Controllers;

use \Firebase\JWT\JWT;
use \App\Models\Auth as AuthModel;
use \App\Core\Random;

/**
 * Auth controller
 */
class AuthController
{

    function login($req, $res, $args)
    {
        if ($req->isPost()) {
            $form_username = Input::post('req_username');
            $form_password = Input::post('req_password');
            $save_pass = (bool) Input::post('save_pass');

            // If form was correctly filled
            if ($form_username && $form_password) {
                $user = AuthModel::get_user_from_name($form_username);

                // Compare user pass with form data
                $form_password_hash = Random::hash($form_password); // Will result in a SHA-1 hash

                if ($user->password == $form_password_hash) {
                    $expire = ($save_pass) ? time() + 1209600 : time() + 1800;
                    $jwt = AuthModel::generate_jwt($user, $expire);

                    AuthModel::feather_setcookie('Bearer '.$jwt, $expire);
                    return Router::redirect(Router::pathFor('home'), 'Welcome '.$user->username.'!');
                } else {
                    throw new \Exception('Wrong user/pass', 403);
                }

            } else {
                throw new \Exception("Username and password are required fields.", 1);
            }
        } elseif ($req->isGet()) {
            return View::setPageInfo(['title' => 'Login', 'active_nav' => 'login'])
                ->addTemplate('login.php')
                ->display();
        }
    }

    function logout($req, $res, $args)
    {
        AuthModel::feather_setcookie('', 1);
        return Router::redirect(Router::pathFor('home'));
    }
}
