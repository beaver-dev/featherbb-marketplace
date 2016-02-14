<?php namespace App\Middleware;

use Firebase\JWT\JWT;
use App\Models\Auth as AuthModel;

class Auth
{

    protected function get_cookie_data($authCookie = null)
    {
        if ($authCookie) {
            /*
             * Extract the jwt from the Bearer
             */
            list($jwt) = sscanf( $authCookie, 'Bearer %s');

            if ($jwt) {
                try {
                    /*
                    * decode the jwt using the key from config
                    */
                    $secretKey = base64_decode(Config::get('jwt')['key']);
                    $token = JWT::decode($jwt, $secretKey, [Config::get('jwt')['algorithm']]);

                    return $token;

                } catch (\Firebase\JWT\ExpiredException $e) {
                    // TODO: (Optionnal) add flash message to say token has expired
                    return false;
                }
            } else {
                // Token is not present (or invalid) in cookie
                return false;
            }
        } else {
            // Auth cookie is not present in headers
            return false;
        }
    }

    public function __invoke($req, $res, $next) {
        // setcookie('authorization', '', 1, '/', '', false, true);
        $authCookie = Container::get('cookie')->get('authorization');

        if ($jwt = $this->get_cookie_data($authCookie)) {
            // If JWT given in cookie is valid, load user infos
            $user = AuthModel::load_user($jwt->data->userId);
            $user->is_guest = false;
            $user->is_admmod = $user->g_id == '1' || $user->g_moderator == '1';

            // Refresh cookie to avoid re-logging between idle
            $expires = ($jwt->exp > time() + 1800) ? time() + 1209600 : time() + 1800;
            $jwt = AuthModel::generate_jwt($user);
            AuthModel::feather_setcookie('Bearer '.$jwt, $expires);
        } else {
            $user = AuthModel::load_user(1);
            $user->is_guest = true;
            $user->is_admmod = false;
        }

        // Add user infos in request attributes and view
        $req = $req->withAttribute('user', $user);
        View::setPageInfo(['user'=>$user]);

        return $next($req, $res);
    }
}
