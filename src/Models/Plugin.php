<?php namespace App\Models;

use ORM;
use App\Model\Github;

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
        $plugin->status = 2;
        $plugin->vendor_name = $vendor_name[1];
        $plugin->readme = Github::getReadmeData($vendor_name[1]);
        $plugin->save();
    }

}
