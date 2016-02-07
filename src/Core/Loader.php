<?php namespace App\Core;

/**
 * Load array of items
 */
class Loader
{

    /**
     * Get all valid plugin files.
     */
    public function getPlugins()
    {
        $plugins = array();

        $folderPlugins = glob(Config::get('forum')['FEATHER_ROOT'].'plugins/*/featherbb.json');
        foreach ($plugins as $plugin_file)
		{
            $plugins[] =  json_decode(file_get_contents($plugin_file));
		}

        natcasesort($plugins);
        return $plugins;
    }

    /**
     * Get available styles
     */
    public function getStyles()
    {
        $styles = array();

        $iterator = new \DirectoryIterator(Config::get('forum')['FEATHER_ROOT'].'style/themes/');
        foreach ($iterator as $child) {
            if(!$child->isDot() && $child->isDir() && file_exists($child->getPathname().DIRECTORY_SEPARATOR.'style.css')) {
                // If the theme is well formed, add it to the list
                $styles[] = $child->getFileName();
            }
        }

        natcasesort($styles);
        return $styles;
    }

    /**
     * Get available langs
     */
    public function getLangs($folder = '')
    {
        $langs = array();

        $iterator = new \DirectoryIterator(Config::get('forum')['FEATHER_ROOT'].'featherbb/lang/');
        foreach ($iterator as $child) {
            if(!$child->isDot() && $child->isDir() && file_exists($child->getPathname().DIRECTORY_SEPARATOR.'common.po')) {
                // If the lang pack is well formed, add it to the list
                $langs[] = $child->getFileName();
            }
        }

        natcasesort($langs);
        return $langs;
    }
}
