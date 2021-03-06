<?php namespace App\Models;

/**
 * Github API class
 */
class Github
{

    public static function getContent($vendor_name, $path, $user = "featherbb", $version = 'master')
    {
        $uri = "https://api.github.com/repos/$user/$vendor_name/contents/$path?ref=$version";

        // Prepare cURL connection
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, "featherbb");
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $data = curl_exec($ch);
        // $error = curl_error($ch);
        curl_close ($ch);

        // Return decoded data as object or FALSE if file doesn't exist
        $data = json_decode($data);
        if (!isset($data->content)) {
            return false;
        }
        $data = base64_decode($data->content);
        return $data;
    }

    public static function forkRepo($user, $vendor_name)
    {
        $uri_post = "https://api.github.com/repos/$user/$vendor_name/forks?organization=featherbb&access_token=".Config::get('githubtoken');

        // Prepare cURL connection
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $uri_post);
        curl_setopt($ch,CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, "featherbb");
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $data = curl_exec($ch);
        // $error = curl_error($ch);

        curl_close ($ch);
    }
}
