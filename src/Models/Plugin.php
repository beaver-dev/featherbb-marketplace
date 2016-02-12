<?php namespace App\Models;

use ORM;
use App\Models\Github;

/**
 * Plugin class
 */
class Plugin
{

    public static function getLatests()
    {
        $plugins = ORM::for_table('plugins')->where('status', 2)->limit(10);
        Container::get('hooks')->fireDB('model.plugins.getLatest', $plugins);
        $plugins = $plugins->find_many();

        return $plugins;
    }

    public static function validate($body)
    {
        // return ['test err', 'erreur 2'];
        return true;
    }

    public static function create($data)
    {
        $plugin = ORM::for_table('plugins')->create();

        $plugin->homepage = $data['homepage'];
        $plugin->name = $data['name'];

        $plugin->save();
    }

    public static function getPending()
    {
        $plugins = ORM::for_table('plugins')->where('status', 0)->find_many();
        foreach ($plugins as $plugin) {
            $vendor_name = str_replace([' ','.'], '-', $plugin->name);
            $plugin->vendor_name = strtolower($vendor_name);
        }
        return $plugins;
    }

    public static function downloadData($plugin_id, $vendor_name)
    {
        // Get main files from Github
        $composer = Github::getContent($vendor_name, 'composer.json');
        $featherbb = Github::getContent($vendor_name, 'featherbb.json');
        $readme = true;
        // $readme = Github::getContent($vendor_name, 'README.md');

        if ($composer === false || $featherbb === false || $readme === false) {
            return false;
        }

        $composerDecoded = json_decode($composer);
        $featherDecoded = json_decode($featherbb);
        $description = $composerDecoded->description;
        $keywords = serialize($composerDecoded->keywords);

        $plugin = ORM::for_table('plugins')->find_one($plugin_id);
        if ($plugin !== false) {
            $plugin->homepage = 'https://github.com/featherbb/'.$vendor_name;
            $plugin->status = 2;
            $plugin->vendor_name = $vendor_name;
            $plugin->author = $featherDecoded->author->name;
            $plugin->description = $description;
            $plugin->keywords = $keywords;
            $plugin->readme = $readme;
            $plugin->save();
        }

        return $plugin;
    }

    public static function getData($vendor_name = '')
    {
        $plugin = ORM::for_table('plugins')->where('vendor_name', $vendor_name)->find_one();

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
                $menu_content[$menu_key] = $result;
            }
            $plugin->menu_content = $menu_content;

            $plugin->keywords = unserialize($plugin->keywords);
        }

        return $plugin;
    }

    public static function getTags($tags)
    {
        $plugins = ORM::for_table('plugins')->where_like('keywords', str_replace('-', ' ', '%'.$tags.'%'))->find_many();
        return $plugins;
    }

    public static function getAuthor($tags)
    {
        $plugins = ORM::for_table('plugins')->where_like('author', str_replace('-', ' ', '%'.$tags.'%'))->find_many();
        return $plugins;
    }

    public static function getSearch($search)
    {
        $plugins = ORM::for_table('plugins')->raw_query('SELECT * FROM plugins WHERE description LIKE :descr OR name LIKE :na OR author LIKE :auth', array('descr' => '%'.$search.'%', 'na' => '%'.$search.'%', 'auth' => '%'.$search.'%'))->find_many();

        return $plugins;
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
