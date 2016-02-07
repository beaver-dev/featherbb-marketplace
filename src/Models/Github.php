<?php namespace App\Models;

/**
 * Github API class
 */
class Github
{

    public static function getReadmeData($vendor_name, $version = 'master')
    {
        // $uri = "https://api.github.com/repos/featherbb/$vendor_name/contents/composer.json?ref=$version";
        // $uri = "https://raw.githubusercontent.com/featherbb/$vendor_name/$version/composer.json";
        $uri = "https://raw.githubusercontent.com/featherbb/$vendor_name/$version/readme";

        // Prepare cURL connection
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, "featherbb");
        $data = curl_exec($ch);
        $error = curl_error($ch);
        curl_close ($ch);

        // Return decoded data as object
        // $data = json_decode($data);
        return $data;
    }

}
