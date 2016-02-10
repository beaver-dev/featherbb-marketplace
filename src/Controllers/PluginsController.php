<?php namespace App\Controllers;

use ORM;
use Michelf\Markdown;
use App\Models\Plugin as PluginModel;
use App\Models\Github as GithubApi;

class PluginsController {

    public function index($req, $res, $args)
    {
        $lastPlugins = PluginModel::getLatests();

        return View::setPageInfo(['lastPlugins' => $lastPlugins])
            ->addBreadcrumb(['plugins'])
            ->addTemplate('plugins/index.php')
            ->display();
    }

    public function pending($req, $res, $args)
    {
        $pendingPlugins = PluginModel::getPending();

        return View::setPageInfo(['plugins' => $pendingPlugins])
            ->addBreadcrumb(['plugins'])
            ->addTemplate('plugins/pending.php')
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
        // Download archive and store info files to disk
        $vendor_name = Request::getParsedBody()['vendor_name'];
        $plugin_id = Request::getParsedBody()['plugin_id'];

        if (PluginModel::downloadData($vendor_name) === false) {
            $notFoundHandler = Container::get('notFoundHandler');
            return $notFoundHandler(Container::get('request'), Container::get('response'));
        }
        // If no errors, store generic infos to DB
        $plugin = PluginModel::accept($plugin_id, $vendor_name);
    }

    public function view($req, $res, $args)
    {
        $plugin = PluginModel::getData($args['name']);

        if ($plugin === false) {
            $notFoundHandler = Container::get('notFoundHandler');
            return $notFoundHandler(Container::get('request'), Container::get('response'));
        }

        $action = isset($args['action']) ? $args['action'] : 'description';

        if ($action === 'history') {
            // $content = json_decode(GithubApi::getTags($args['name']));
            $content = GithubApi::getTags($args['name']);
        } elseif (!isset($plugin->menu_content[$action])) {
            $content = Markdown::defaultTransform($plugin->menu_content['description']);
        } else {
            $content = Markdown::defaultTransform($plugin->menu_content[$action]);
        }

        return View::setPageInfo(['plugin' => $plugin, 'content' => $content, 'active_menu' => $action])
            ->addBreadcrumb(['plugins'])
            ->addTemplate('plugins/view.php')
            ->display();
    }

    public function download($req, $res, $args)
    {
        $plugin = ORM::for_table('plugins')->where('vendor_name', $args['name'])->find_one();

        if (!$plugin) {
            $notFoundHandler = Container::get('notFoundHandler');
            return $notFoundHandler(Container::get('request'), Container::get('response'));
        }

        $plugin->nb_downloads = $plugin->nb_downloads+1;
        $plugin->save();
        $version = isset($args['version']) ? $args['version'] : 'master';
        // https://api.github.com/repos/featherbb/private-messages/zipball/0.1.0
        // https://api.github.com/repos/featherbb/private-messages/releases
        return Router::redirect('https://api.github.com/repos/featherbb/'.$plugin->vendor_name.'/zipball/'.$version);
    }

    public function history($req, $res, $args)
    {
        $plugin = PluginModel::getData($args['name']);

        if ($plugin === false) {
            $notFoundHandler = Container::get('notFoundHandler');
            return $notFoundHandler(Container::get('request'), Container::get('response'));
        }

        $history = PluginModel::history($args['name']);

        return View::setPageInfo(['plugin' => $plugin, 'markdown' => $markdown])
            ->addBreadcrumb(['plugins'])
            ->addTemplate('plugins/view.php')
            ->display();
    }

}
