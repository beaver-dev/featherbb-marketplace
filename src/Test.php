<?php namespace App;


// use App\Core\Plugin as BasePlugin;

class Test implements \App\Core\PluginInterface
{
    public function attachEvents()
    {
        Container::get('hooks')->bind('model.plugins.getLatest', function($plugins){
            // $plugins = $plugins->where_not_equal('id', 1);
            return $plugins;
        });
    }

    public function __invoke($req, $res, $next)
    {
        // Container::get('hooks')->bind('model.plugins.getLatest', function($plugins){
        //     // $plugins = $plugins->where_not_equal('id', 1);
        //     return $plugins;
        // });
        echo "string";
        return $next($req, $res);
    }

}
