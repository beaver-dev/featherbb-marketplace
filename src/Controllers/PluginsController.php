<?php namespace App\Controllers;

use ORM;
use Michelf\Markdown;
use App\Models\Plugin as PluginModel;
// use App\Models\Github as GithubApi;
// use Model;

class PluginsController {

    public function index($req, $res, $args)
    {
        $lastPlugins = PluginModel::getLatests();
        // $data = GithubApi::getComposerData('private-messages');

        return View::setPageInfo(['lastPlugins' => $lastPlugins])
            ->addBreadcrumb(['plugins'])
            ->addTemplate('plugins/index.php')
            ->display();
    }

    public function view($req, $res, $args)
    {
        $plugin = PluginModel::getData($args['name']);

        if (!isset($args['action']) || !isset($plugin->menu_content[$args['action']])) {
            $item = 'description';
        } else {
            $item = $args['action'];
        }
        $markdown = Markdown::defaultTransform($plugin->menu_content[$item]);

        return View::setPageInfo(['plugin' => $plugin, 'markdown' => $markdown])
            ->addBreadcrumb(['plugins'])
            ->addTemplate('plugins/view.php')
            ->display();
    }

    public function create($req, $res, $args)
    {
        // Prepare base data to send to view
        $data = [];
        if (Request::isPost()) {
            // Check if plugin is valid
            $validate = PluginModel::validate(Request::getParsedBody());
            if ($validate !== true) {
                $data['errors'] = $validate;
            } else {
                PluginModel::create(Request::getParsedBody());
                return Router::redirect(Router::pathFor('plugins.create'));
            }
        }
        // Display view
        return View::setPageInfo($data)
            ->addTemplate('plugins/create.php')
            ->display();
    }

    public function accept($req, $res, $args)
    {
        // Prepare base data to send to view
        // $id = Request::getParsedBody()['plugin_id'];
        // $homepage = Request::getParsedBody()['homepage'];
        // var_dump(Request::getParsedBody());
        $plugin = PluginModel::accept(Request::getParsedBody());
        $name = PluginModel::downloadData($plugin->homepage);
        var_dump($name);
    }

    public function pending($req, $res, $args)
    {
        $pendingPlugins = PluginModel::getPending();
        // $data = GithubApi::getComposerData('private-messages');

        return View::setPageInfo(['plugins' => $pendingPlugins])
            ->addBreadcrumb(['plugins'])
            ->addTemplate('plugins/pending.php')
            ->display();
    }

    public function download($req, $res, $args)
    {
        $plugin = ORM::for_table('plugins')->where('vendor_name', $args['name'])->find_one();
        if (!$plugin) {
            return "not found";
        }
        $plugin->nb_downloads = $plugin->nb_downloads+1;
        $plugin->save();
        $version = isset($args['version']) ? $args['version'] : 'master';
        // https://api.github.com/repos/featherbb/private-messages/zipball/0.1.0
        // https://api.github.com/repos/featherbb/private-messages/releases
        return Router::redirect('https://api.github.com/repos/featherbb/'.$plugin->vendor_name.'/zipball/'.$version);
    }

}
