<?php namespace App\Models;

use ORM;
use App\Models\Github;

/**
 * Plugin class
 */
class Plugin
{

    public static function getIndex($offset = 0)
    {
        $plugins = ORM::for_table('market_plugins')
                    ->where('status', 2)
                    ->limit(20)
                    ->offset($offset)
                    ->find_many();

        return $plugins;
    }

    public static function validate($body)
    {
        // return ['test err', 'erreur 2'];
        return true;
    }

    public static function create($data)
    {
        $plugin = ORM::for_table('market_plugins')->create();

        $parts = explode('/', str_ireplace(array('http://', 'https://'), '', $data['homepage']));

        $plugin->homepage = $data['homepage'];
        $plugin->name = $data['name'];
        $plugin->author = $data['author'];
        $plugin->vendor_name = $parts[2];

        $plugin->save();
    }

    public static function getPending()
    {
        $plugins = ORM::for_table('market_plugins')->order_by_asc('name')->where('status', 0)->find_many();
        // foreach ($plugins as $plugin) {
        //     $vendor_name = str_replace([' ','.'], '-', $plugin->name);
        //     $plugin->vendor_name = strtolower($vendor_name);
        // }
        return $plugins;
    }

    public static function downloadData($plugin_id, $vendor_name, $user = "featherbb")
    {
        // Get main files from Github
        $composer = Github::getContent($vendor_name, 'composer.json', $user);
        $featherbb = Github::getContent($vendor_name, 'featherbb.json', $user);
        $readme = Github::getContent($vendor_name, 'README.md', $user);

        if ($composer === false || $featherbb === false || $readme === false) {
            return false;
        }

        $composerDecoded = json_decode($composer);
        $featherDecoded = json_decode($featherbb);

        $plugin = ORM::for_table('market_plugins')->find_one($plugin_id);
        if ($plugin !== false) {
            $plugin->homepage = 'https://github.com/featherbb/'.$vendor_name;
            $plugin->status = 2;
            $plugin->vendor_name = $vendor_name;
            $plugin->last_version = $featherDecoded->version;
            $plugin->last_update = time();
            $plugin->description = $composerDecoded->description;
            $plugin->keywords = serialize($composerDecoded->keywords);
            $plugin->readme = $readme;
            $plugin->save();
        }

        return $plugin;
    }

    public static function getData($vendor_name = '')
    {
        $plugin = ORM::for_table('market_plugins')->where('vendor_name', $vendor_name)->find_one();

        if ($plugin !== false) {
            // Get menu items to display in plugin infos (remove first item of array which is h1 and not h2)...
            preg_match_all('/\s\s#{2} (.+)/S', $plugin->readme, $plugin_menus, PREG_PATTERN_ORDER);
            if (isset($plugin_menus[1])) {
                $plugin->menus = $plugin_menus[1];
            }

            // Parse readme to get each h2 body content...
            $results = preg_split('/\s\s## \w+\s\s.*?/', $plugin->readme, -1, PREG_SPLIT_NO_EMPTY);
            if (isset($results[0])) {
                $plugin->general_infos = $results[0];
            }

            array_shift($results);

            // And associate h2 menu items with their content as an array
            $menu_content = [];
            foreach ($results as $key => $result) {
                $menu_key = strtolower($plugin->menus[$key]);
                $menu_content[$menu_key] = htmlspecialchars($result);
            }
            $plugin->menu_content = $menu_content;

            $plugin->keywords = unserialize($plugin->keywords);
        }

        return $plugin;
    }

    public static function countGetTags($tags)
    {
        $nbPlugins = ORM::for_table('market_plugins')
                    ->where_like('keywords', str_replace('-', ' ', '%'.$tags.'%'))
                    ->where('status', 2)
                    ->count();
        return $nbPlugins;
    }
    public static function getTags($tags, $offset = 0)
    {
        $plugins = ORM::for_table('market_plugins')
                    ->where_like('keywords', str_replace('-', ' ', '%'.$tags.'%'))
                    ->where('status', 2)
                    ->limit(20)
                    ->offset($offset)
                    ->find_many();
        return $plugins;
    }

    public static function countGetAuthor($author)
    {
        $nbPlugins = ORM::for_table('market_plugins')
                    ->where_like('author', str_replace('-', ' ', '%'.$author.'%'))
                    ->where('status', 2)
                    ->count();
        return $nbPlugins;
    }
    public static function getAuthor($author, $offset = 0)
    {
        $plugins = ORM::for_table('market_plugins')
                    ->where_like('author', str_replace('-', ' ', '%'.$author.'%'))
                    ->where('status', 2)
                    ->limit(20)
                    ->offset($offset)
                    ->find_many();
        return $plugins;
    }

    public static function countGetSearch($search)
    {
        $nbPlugins = ORM::for_table('market_plugins')
                    ->raw_query('SELECT * FROM market_plugins WHERE description LIKE :descr OR name LIKE :na OR author LIKE :auth', array('descr' => '%'.$search.'%', 'na' => '%'.$search.'%', 'auth' => '%'.$search.'%'))
                    ->where('status', 2)
                    ->count();
        return $nbPlugins;
    }
    public static function getSearch($search, $offset = 0)
    {
        $plugins = ORM::for_table('market_plugins')
                    ->raw_query('SELECT * FROM market_plugins WHERE description LIKE :descr OR name LIKE :na OR author LIKE :auth', array('descr' => '%'.$search.'%', 'na' => '%'.$search.'%', 'auth' => '%'.$search.'%'))
                    ->where('status', 2)
                    ->limit(20)
                    ->offset($offset)
                    ->find_many();
        return $plugins;
    }

    public static function getUser($vendor_name)
    {
        $user = ORM::for_table('market_plugins')->select('homepage')->where('vendor_name', $vendor_name)->find_one();

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
