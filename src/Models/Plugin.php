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

    public static function update($data)
    {
        $plugin = ORM::for_table('plugins')->create();

        $plugin->homepage = $data['homepage'];
        $plugin->name = $data['name'];

        $plugin->save();
    }

    public static function getPending()
    {
        $plugins = ORM::for_table('plugins')->where('status', 0)->find_many();
        return $plugins;
    }

    public static function accept(array $data)
    {
        preg_match('/featherbb\/(.+)/', $data['homepage'], $vendor_name);
        $plugin = ORM::for_table('plugins')->find_one($data['plugin_id']);

        $plugin->homepage = $data['homepage'];
        // $plugin->status = 2;
        $plugin->vendor_name = $vendor_name[1];
        // $plugin->readme = Github::getReadmeData($vendor_name[1]);
        $plugin->save();

        return $plugin;
    }

    public static function downloadData($uri='')
    {
        // Prepare data for archive download
        preg_match('/featherbb\/(.+)/', $uri, $name);
        $name = $name[1];
        $uri = rtrim($uri, '/').'/archive/master.zip'; // Append plugin latest release zipball to download
        $archive_path = getcwd()."/tmp/$name.zip";
        $data_path = getcwd()."/pluginsdata/$name/";

        // Download archive in tmp folder
        file_put_contents($archive_path, file_get_contents($uri));

        // Remove old files if present
        if (!is_dir($data_path))
            mkdir($data_path);
        emptyDir($data_path);

        $zip = new \ZipArchive;
        if ($zip->open($archive_path) === true) {

            // Move needed files to pluginsdata folder
            for($i = 0; $i < $zip->numFiles; $i++) {
                $filename = str_replace($name.'-master/', '', $zip->getNameIndex($i));
                // Filter files to move
                if ($filename == 'composer.json' || substr($filename, 0, 3) === 'doc' || substr($filename, 0, 6) === 'assets') {
                    $zip->renameIndex($i, $filename);
                    $zip->extractTo($data_path, array($zip->getNameIndex($i)));
                }
            }
            $zip->close();
            $result = true;
        } else {
            $result = false;
        }

        unlink($archive_path);

        return $result;
    }

    public static function getData($name = '')
    {
        $plugin = ORM::for_table('plugins')->where('vendor_name', $name)->find_one();

        if ($plugin === false) {
            App::notFound();
        }

        // Get menu items to display in plugin infos...
        preg_match_all('/\s\s#{2} (.+)/S', $plugin->readme, $plugin_menus, PREG_PATTERN_ORDER);
        $plugin->menus = $plugin_menus[1];
        // var_dump($plugin_menus[1]);

        // Parse readme to get each h2 body content...
        $results = preg_split('/\s\s## \w+\s\s.*?/', $plugin->readme, -1, PREG_SPLIT_NO_EMPTY);
        $general_infos = $results[0];
        array_shift($results);
        // var_dump($results);

        // And associate h2 menu items with their content as an array
        $menu_content = [];
        foreach ($results as $key => $result) {
            $menu_key = strtolower($plugin->menus[$key]);
            $menu_content[$menu_key] = $result;
        }
        $plugin->menu_content = $menu_content;

        return $plugin;
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
