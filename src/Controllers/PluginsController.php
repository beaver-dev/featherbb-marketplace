<?php namespace App\Controllers;

use ORM;
use Michelf\Markdown;
use App\Models\Plugin as PluginModel;
use App\Models\Github as GithubApi;

class PluginsController {

    public function index($req, $res, $args)
    {
        $lastPlugins = PluginModel::getLatests();

        return View::setPageInfo([
                'lastPlugins' => $lastPlugins,
                'title' => 'Plugins',
                'top_right_link' => ['url' => Router::pathFor('plugins.create'), 'text' => 'Add plugin']
            ])
            ->addBreadcrumb([Router::pathFor('plugins') => 'Plugins'])
            ->addTemplate('plugins/index.php')
            ->display();
    }

    public function pending($req, $res, $args)
    {
        $pendingPlugins = PluginModel::getPending();

        return View::setPageInfo([
                'plugins' => $pendingPlugins,
                'title' => 'Pending plugins'
            ])
            ->addBreadcrumb([
                Router::pathFor('plugins') => 'Plugins',
                Router::pathFor('plugins.pending') => 'Pending'
            ])
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
            return $notFoundHandler($req, $res);
        }
        // If no errors, store generic infos to DB
        $plugin = PluginModel::accept($plugin_id, $vendor_name);
    }

    public function view($req, $res, $args)
    {
        $plugin = PluginModel::getData($args['name']);

        if ($plugin === false) {
            $notFoundHandler = Container::get('notFoundHandler');
            return $notFoundHandler($req, $res);
        }

        $action = isset($args['action']) ? $args['action'] : 'description';

        $content = '';
        if ($action === 'history') {
            // $content = json_decode(GithubApi::getTags($args['name']));
            $content = GithubApi::getTags($args['name']);
        } elseif (!isset($plugin->menu_content[$action]) && isset($plugin->menu_content['description'])) {
            $content = Markdown::defaultTransform($plugin->menu_content['description']);
        } elseif (isset($plugin->menu_content[$action])) {
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
            return $notFoundHandler($req, $res);
        }

        $plugin->nb_downloads = $plugin->nb_downloads+1;
        $plugin->save();
        $version = isset($args['version']) ? $args['version'] : 'master';
        return Router::redirect('https://api.github.com/repos/featherbb/'.$plugin->vendor_name.'/zipball/'.$version);
    }

    public function tags($req, $res, $args)
    {
        var_dump($args);
        var_dump(str_replace('-', ' ', $args['tag']));
        $plugin = ORM::for_table('plugins')->where_like('keywords', str_replace('-', ' ', '%'.$args['tag'].'%'))->find_many();
        var_dump($plugin);
    }

}
