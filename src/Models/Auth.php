<?php namespace App\Models;

use ORM;
use App\Core\Random;
use Firebase\JWT\JWT;

/**
 * Auth model
 */
class Auth
{

    public static function load_user($user_id)
    {
        $user_id = (int) $user_id;
        $result['select'] = array('u.*', 'g.*');
        $result['where'] = array('u.id' => $user_id);

        $result = ORM::for_table('users')
                    ->table_alias('u')
                    ->select_many($result['select'])
                    ->inner_join('groups', array('u.group_id', '=', 'g.g_id'), 'g')
                    ->where($result['where'])
                    ->find_one();
        return $result;
    }

    public static function get_user_from_name($username)
    {
        return ORM::for_table('users')->where('username', $username)->find_one();
    }

    public static function generate_jwt($user, $expire)
    {
        $issuedAt   = time();
        $tokenId    = base64_encode(Random::key(32));
        $serverName = Config::get('serverName');

        /*
        * Create the token as an array
        */
        $data = [
            'iat'  => $issuedAt,         // Issued at: time when the token was generated
            'jti'  => $tokenId,          // Json Token Id: an unique identifier for the token
            'iss'  => $serverName,       // Issuer
            'exp'  => $expire,           // Expire after 30 minutes of idle or 14 days if "remember me"
            'data' => [                  // Data related to the signer user
                'userId'   => $user->id, // userid from the users table
                'userName' => $user->username, // User name
            ]
        ];

        /*
        * Extract the key, which is coming from the config file.
        *
        * Generated with base64_encode(openssl_random_pseudo_bytes(64));
        */
        $secretKey = base64_decode(Config::get('jwt')['key']);

        /*
        * Extract the algorithm from the config file too
        */
        $algorithm = Config::get('jwt')['algorithm'];

        /*
        * Encode the array to a JWT string.
        * Second parameter is the key to encode the token.
        *
        * The output string can be validated at http://jwt.io/
        */
        $jwt = JWT::encode(
            $data,      //Data to be encoded in the JWT
            $secretKey, // The signing key
            $algorithm  // Algorithm used to sign the token, see https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40#section-3
        );

        return $jwt;
    }

    public static function feather_setcookie($jwt, $expire)
    {
        // Store cookie to client storage
        setcookie('authorization', $jwt, $expire, '/', '', false, true);
    }
}
