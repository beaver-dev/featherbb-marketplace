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
            ->addBreadcrumb(['Plugins'])
            ->addTemplate('plugins/index.php')
            ->display();
    }

    public function pending($req, $res, $args)
    {
        // Ensure user is admmod on forum
        $user = $req->getAttribute('user');
        if (!$user->is_admmod) {
            $notFoundHandler = Container::get('notFoundHandler');
            return $notFoundHandler($req, $res);
        }

        $pendingPlugins = PluginModel::getPending();

        return View::setPageInfo([
                'plugins' => $pendingPlugins,
                'title' => 'Pending plugins'
            ])
            ->addBreadcrumb([
                Router::pathFor('plugins') => 'Plugins',
                'Pending'
            ])
            ->addTemplate('plugins/pending.php')
            ->display();
    }

    public function create($req, $res, $args)
    {
        // Ensure user is logged
        $user = $req->getAttribute('user');
        if ($user->is_guest) {
            return Router::redirect(Router::pathFor('login'));
        }

        // Prepare base data to send to view
        $data = [];
        if (Request::isPost()) {
            $plugin = [
                'homepage' => Request::getParsedBody()['homepage'],
                'name' => Request::getParsedBody()['name'],
                'author' => $user->username
            ];
            // Check if plugin is valid
            $validate = PluginModel::validate($plugin);
            if ($validate !== true) {
                $data['errors'] = $validate;
            } else {
                PluginModel::create($plugin);
                return Router::redirect(Router::pathFor('plugins.create'));
            }
        }
        // Display view
        return View::setPageInfo($data)
            ->addBreadcrumb([
                Router::pathFor('plugins') => 'Plugins',
                'Submit new plugin'
            ])
            ->addTemplate('plugins/create.php')
            ->display();
    }

    public function accept($req, $res, $args)
    {
        // Ensure user is admmod on forum
        $user = $req->getAttribute('user');
        if (!$user->is_admmod) {
            $notFoundHandler = Container::get('notFoundHandler');
            return $notFoundHandler($req, $res);
        }

        // Download archive and store info files to disk
        $vendor_name = Request::getParsedBody()['vendor_name'];
        $plugin_id = Request::getParsedBody()['plugin_id'];

        // Check required fields are sent from form
        if (!isset($vendor_name) || !isset($plugin_id)) {
            $notFoundHandler = Container::get('notFoundHandler');
            return $notFoundHandler($req, $res);
        }

        // Check vendor name is unique
        if (ORM::for_table('market_plugins')->where('vendor_name', $vendor_name)->count() > 0) {
            return 'Vendor name already exists!';
        }

        if (isset(Request::getParsedBody()['accept_plugin'])) {
            // If no errors while getting data from Github, store generic infos to DB, else throw 404
            if (PluginModel::downloadData($plugin_id, $vendor_name) === false) {
                $notFoundHandler = Container::get('notFoundHandler');
                return $notFoundHandler($req, $res);
            }
        } elseif (isset(Request::getParsedBody()['delete_plugin'])) {
            // TODO: Remove plugin from DB
        }

        return Router::redirect(Router::pathFor('plugins.pending'));
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
        $plugin = ORM::for_table('market_plugins')->where('vendor_name', $args['name'])->find_one();

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
        $plugins = PluginModel::getTags($args['tag']);

        return View::setPageInfo([
            'lastPlugins' => $plugins,
            'title' => 'Tags',
            'top_right_link' => ['url' => Router::pathFor('plugins.create'), 'text' => 'Add plugin']
        ])
            ->addBreadcrumb(['Plugins'])
            ->addTemplate('plugins/index.php')
            ->display();
    }

    public function author($req, $res, $args)
    {
        $plugins = PluginModel::getAuthor($args['author']);

        return View::setPageInfo([
            'lastPlugins' => $plugins,
            'title' => 'Author',
            'top_right_link' => ['url' => Router::pathFor('plugins.create'), 'text' => 'Add plugin']
        ])
            ->addBreadcrumb(['Plugins'])
            ->addTemplate('plugins/index.php')
            ->display();
    }

    public function search($req, $res, $args)
    {
        if (isset(Request::getQueryParams()['keywords'])) {
            $plugins = PluginModel::getSearch(Request::getQueryParams()['keywords']);
        }
        else {
            $notFoundHandler = Container::get('notFoundHandler');
            return $notFoundHandler($req, $res);
        }

        return View::setPageInfo([
            'lastPlugins' => $plugins,
            'title' => 'Search',
            'top_right_link' => ['url' => Router::pathFor('plugins.create'), 'text' => 'Add plugin']
        ])
            ->addBreadcrumb(['Plugins'])
            ->addTemplate('plugins/index.php')
            ->display();
    }

}
