<?php namespace App\Core;

class Plugin
{
    // public function attachEvents()
    // {
    //     // $emitter->bind('post.start', function ($args) {
    // }

    public function download($uri = null)
    {
        // $uri = "https://github.com/featherbb/featherbb/archive/1.0.0-beta.2.zip";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_SSLVERSION,3);
        $data = curl_exec ($ch);
        $error = curl_error($ch);
        curl_close ($ch);

        preg_match('/archive\/(.+)/', $uri, $name);
        $name = $name[1];

        $destination = "./plugins/$name.zip";
        $file = fopen($destination, "w+");
        fputs($file, $data);
        fclose($file);
    }

    // public function getActivePlugins()
    // {
    //     $activePlugins = $this->feather->cache->isCached('active_plugins') ? $this->feather->cache->retrieve('active_plugins') : array();
    //
    //     return $activePlugins;
    // }
    //
    // /**
    //  * Run activated plugins
    //  */
    // public function loadPlugins()
    // {
    //     $activePlugins = $this->getActivePlugins();
    //
    //     foreach ($activePlugins as $plugin) {
    //         if ($class = $this->load($plugin)) {
    //             $class->run();
    //         }
    //     }
    // }
    //
    // /**
    //  * Activate a plugin
    //  */
    // public function activate($plugin)
    // {
    //     $activePlugins = $this->getActivePlugins();
    //
    //     // Check if plugin is not yet activated
    //     if (!in_array($plugin, $activePlugins)) {
    //         $activePlugins[] = $plugin;
    //
    //         $class = $this->load($plugin);
    //         $class->install();
    //
    //         $this->feather->cache->store('active_plugins', $activePlugins);
    //     }
    // }
    //
    // public function install()
    // {
    //     // Daughter classes may override this method for custom install
    // }
    //
    // /**
    //  * Deactivate a plugin
    //  */
    // public function deactivate($plugin)
    // {
    //     $activePlugins = $this->getActivePlugins();
    //
    //     // Check if plugin is actually activated
    //     if (($k = array_search($plugin, $activePlugins)) !== false) {
    //         unset($activePlugins[$k]);
    //         $this->feather->cache->store('active_plugins', $activePlugins);
    //     }
    // }
    //
    // public function uninstall($plugin)
    // {
    //     // Daughter classes may override this method for custom uninstall
    //     $this->deactivate($plugin);
    //
    //     $class = $this->load($plugin);
    //     $class->uninstall();
    // }
    //
    // public function run()
    // {
    //     // Daughter classes may override this method for custom run
    // }
    //
    // protected function load($plugin)
    // {
    //     if (file_exists($file = $this->feather->forum_env['FEATHER_ROOT'].'plugins/'.$plugin.'/bootstrap.php')) {
    //         $className = require $file;
    //         $class = new $className();
    //         return $class;
    //     }
    //     return false;
    // }

    //     public static function loadHooks()
    //     {
    //         # NOTE: ** is the ACTIVATED plugins array
    //         #
    //         # require all /plugins/**/hooks.php files to find & register all plugins hooks
    //         # OR
    //         # use Slim middlewares __invoke function for each ** instead of
    //         # making a full plugins register system ?
    //     }
}
