<?php namespace App\Models;

use ORM;
use App\Models\Github as GithubApi;

/**
 * Plugin class
 */
class Theme
{

    public static function getIndex($offset = 0)
    {
        $themes = ORM::for_table('market_themes')
                    ->where('status', 2)
                    ->limit(20)
                    ->offset($offset)
                    ->find_many();

        return $themes;
    }

    public static function create($data)
    {
        $theme = ORM::for_table('market_themes')->create();

        // $parts = explode('/', str_ireplace(array('http://', 'https://'), '', $data['homepage']));

        $theme->homepage = $data['homepage'];
        $theme->name = $data['name'];
        $theme->author = $data['author'];
        // $theme->vendor_name = $parts[2];

        $theme->save();
    }

    public static function getPending()
    {
        $themes = ORM::for_table('market_themes')->order_by_asc('name')->where('status', 0)->find_many();
        foreach ($themes as $theme) {
            $vendor_name = str_replace([' ','.'], '-', $theme->name);
            $theme->vendor_name = strtolower($vendor_name);
        }
        return $themes;
    }

    public static function downloadData($theme_id, $vendor_name)
    {
        $theme = ORM::for_table('market_themes')->find_one($theme_id);
        if ($theme === false) {
            return false;
        }

        // Get main files from Github
        $userGit = explode('/', str_ireplace(array('http://', 'https://'), '', $theme->homepage));

        $readme = Github::getContent($userGit[2], 'README.md', $userGit[1]);
        $featherbb = Github::getContent($userGit[2], 'featherbb.json', $userGit[1]);

        if ($featherbb === false || $readme === false) {
            return false;
        }

        $featherDecoded = json_decode($featherbb);

        $theme->status = 2;
        $theme->vendor_name = $vendor_name;
        $theme->last_version = $featherDecoded->version;
        $theme->last_update = time();
        $theme->keywords = serialize($featherDecoded->keywords);
        $theme->readme = $readme;
        $theme->save();

        return $theme;
    }

    public static function getData($vendor_name = '')
    {
        $theme = ORM::for_table('market_themes')->where('vendor_name', $vendor_name)->find_one();

        return $theme;
    }

    public static function countGetTags($tags)
    {
        $nbPlugins = ORM::for_table('market_themes')
                    ->where_like('keywords', str_replace('-', ' ', '%'.$tags.'%'))
                    ->where('status', 2)
                    ->count();
        return $nbPlugins;
    }
    public static function getTags($tags, $offset = 0)
    {
        $themes = ORM::for_table('market_themes')
                    ->where_like('keywords', str_replace('-', ' ', '%'.$tags.'%'))
                    ->where('status', 2)
                    ->limit(20)
                    ->offset($offset)
                    ->find_many();
        return $themes;
    }

    public static function countGetAuthor($author)
    {
        $nbPlugins = ORM::for_table('market_themes')
                    ->where_like('author', str_replace('-', ' ', '%'.$author.'%'))
                    ->where('status', 2)
                    ->count();
        return $nbPlugins;
    }
    public static function getAuthor($author, $offset = 0)
    {
        $themes = ORM::for_table('market_themes')
                    ->where_like('author', str_replace('-', ' ', '%'.$author.'%'))
                    ->where('status', 2)
                    ->limit(20)
                    ->offset($offset)
                    ->find_many();
        return $themes;
    }

    public static function countGetSearch($search)
    {
        $nbPlugins = ORM::for_table('market_themes')
                    ->raw_query('SELECT * FROM market_themes WHERE description LIKE :descr OR name LIKE :na OR author LIKE :auth', array('descr' => '%'.$search.'%', 'na' => '%'.$search.'%', 'auth' => '%'.$search.'%'))
                    ->where('status', 2)
                    ->count();
        return $nbPlugins;
    }
    public static function getSearch($search, $offset = 0)
    {
        $themes = ORM::for_table('market_themes')
                    ->raw_query('SELECT * FROM market_themes WHERE description LIKE :descr OR name LIKE :na OR author LIKE :auth', array('descr' => '%'.$search.'%', 'na' => '%'.$search.'%', 'auth' => '%'.$search.'%'))
                    ->where('status', 2)
                    ->limit(20)
                    ->offset($offset)
                    ->find_many();
        return $themes;
    }

    public static function getUser($vendor_name)
    {
        $user = ORM::for_table('market_themes')->select('homepage')->where('name', $vendor_name)->find_one();

        return $user['homepage'];
    }

}



// Closure to empty previous data from "public/pluginsdata" directory
function emptyDir($path)
{
    if (is_dir($path) === true)
    {
        $files = array_diff(scandir($path), array('.', '..'));

        foreach ($files as $file)
        {
            emptyDir(realpath($path) . '/' . $file);
        }

        return rmdir($path);
    }

    else if (is_file($path) === true)
    {
        return unlink($path);
    }

    return false;
}
