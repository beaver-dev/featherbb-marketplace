<?php namespace App\Controllers;

use ORM;
use Michelf\Markdown;
use App\Models\Plugin as PluginModel;
use App\Models\Github as GithubApi;

class PluginsController extends BaseController {

    // public function __construct($container) {
    //     parent::__construct($container);
    // }

    public function index($req, $res, $args)
    {
        // Get number of pages
        $nbPlugins = ORM::for_table('market_plugins')->where('status', 2)->count();
        $nbPages = ceil(($nbPlugins + 1) / 20);
        // Determine the offset
        $p = (!isset($args['page']) || $args['page'] <= 1 || $args['page'] > $nbPages) ? 1 : intval($args['page']);
        $offset = 20 * ($p - 1);
        // Generate paging links
        $pagination = Router::paginate($nbPages, $p, 'plugins/#');

        $plugins = PluginModel::getIndex($offset);

        return View::setPageInfo([
                'plugins' => $plugins,
                'pagination' => $pagination,
                'title' => 'Plugins',
                'active_nav' => 'plugins',
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
                'active_nav' => 'plugins',
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
            return Router::redirect(Router::pathFor('login'), 'You must be logged in to submit a new plugin');
        }

        // Prepare base data to send to view
        $data = ['active_nav' => 'plugins'];
        if (Request::isPost()) {
            $plugin = [
                'homepage' => Input::post('homepage'),
                'name' => Input::post('name'),
                'author' => $user->username
            ];
            // Check if plugin is valid
            $validate = PluginModel::validate($plugin);
            if ($validate !== true) {
                $data['errors'] = $validate;
            } else {
                PluginModel::create($plugin);
                return Router::redirect(Router::pathFor('plugins.create'), 'Plugin submitted');
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
        $vendor_name = Input::post('vendor_name');
        $plugin_id = Input::post('plugin_id');

        // Check required fields are sent from form
        if (!$vendor_name || !$plugin_id) {
            $notFoundHandler = Container::get('notFoundHandler');
            return $notFoundHandler($req, $res);
        }

        // Check vendor name is unique
        if (ORM::for_table('market_plugins')->where('vendor_name', $vendor_name)->where('status', 2)->count() > 0) {
            return 'Vendor name already exists!';
        }

        $repoURL = PluginModel::getUser($vendor_name);
        $userGit = explode('/', str_ireplace(array('http://', 'https://'), '', $repoURL));

        if (Input::post('accept_plugin')) {
            // If no errors while getting data from Github, store generic infos to DB, else throw 404
            if (PluginModel::downloadData($plugin_id, $vendor_name, $userGit[1]) === false) {
                $notFoundHandler = Container::get('notFoundHandler');
                return $notFoundHandler($req, $res);
            }
            else {
                GithubApi::forkRepo($userGit[1], $vendor_name);
            }
        } elseif (Input::post('delete_plugin')) {
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
        if (!isset($plugin->menu_content[$action]) && isset($plugin->menu_content['description'])) {
            $content = Markdown::defaultTransform($plugin->menu_content['description']);
        } elseif (isset($plugin->menu_content[$action])) {
            $content = Markdown::defaultTransform($plugin->menu_content[$action]);
        } else {
            $content = 'No content found for this tab.';
        }

        return View::setPageInfo(['plugin' => $plugin, 'content' => $content, 'active_menu' => $action, 'active_nav' => 'plugins'])
            ->addBreadcrumb([
                Router::pathFor('plugins') => 'Plugins',
                htmlspecialchars($plugin->name)
            ])
            ->addTemplate('plugins/view.php')
            ->display();
    }

    public function update($req, $res, $args)
    {
        $plugin = PluginModel::getData($args['name']);
        $user = $req->getAttribute('user');

        // Ensure plugin exists and user has rights to update it
        if (!$plugin || ($plugin->author != $user->username && !$user->is_admmod)) {
            $notFoundHandler = Container::get('notFoundHandler');
            return $notFoundHandler($req, $res);
        }

        PluginModel::downloadData($plugin->id, $plugin->vendor_name);

        return Router::redirect(Router::pathFor('plugins.view', ['name' => $plugin->vendor_name]), 'Plugin updated!');
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
        // Get number of pages
        $nbPlugins = PluginModel::countGetTags($args['tag']);
        $nbPages = ceil(($nbPlugins + 1) / 20);
        // Determine the offset
        $p = (!isset($args['page']) || $args['page'] <= 1 || $args['page'] > $nbPages) ? 1 : intval($args['page']);
        $offset = 20 * ($p - 1);
        // Generate paging links
        $pagination = Router::paginate($nbPages, $p, 'plugins/tags/'.$args['tag'].'/#');

        $plugins = PluginModel::getTags($args['tag'], $offset);

        return View::setPageInfo([
                'plugins' => $plugins,
                'pagination' => $pagination,
                'title' => 'Tags',
                'active_nav' => 'plugins',
                'top_right_link' => ['url' => Router::pathFor('plugins.create'), 'text' => 'Add plugin']
            ])
            ->addBreadcrumb([
                Router::pathFor('plugins') => 'Plugins',
                'Search by tags'
            ])
            ->addTemplate('plugins/index.php')
            ->display();
    }

    public function author($req, $res, $args)
    {
        // Get number of pages
        $nbPlugins = PluginModel::countGetAuthor($args['author']);
        $nbPages = ceil(($nbPlugins + 1) / 20);
        // Determine the offset
        $p = (!isset($args['page']) || $args['page'] <= 1 || $args['page'] > $nbPages) ? 1 : intval($args['page']);
        $offset = 20 * ($p - 1);
        // Generate paging links
        $pagination = Router::paginate($nbPages, $p, 'plugins/author/'.$args['author'].'/#');

        $plugins = PluginModel::getAuthor($args['author']);

        return View::setPageInfo([
                'plugins' => $plugins,
                'pagination' => $pagination,
                'title' => 'Author',
                'active_nav' => 'plugins',
                'top_right_link' => ['url' => Router::pathFor('plugins.create'), 'text' => 'Add plugin']
            ])
            ->addBreadcrumb([
                Router::pathFor('plugins') => 'Plugins',
                'Authored by '.htmlspecialchars($args['author'])
            ])
            ->addTemplate('plugins/index.php')
            ->display();
    }

    public function search($req, $res, $args)
    {
        if (!Input::query('keywords')) {
            return Router::redirect(Router::pathFor('plugins'));
        }

        // Get number of pages
        $nbPlugins = PluginModel::countGetSearch(Input::query('keywords'));
        $nbPages = ceil(($nbPlugins + 1) / 20);
        // Determine the offset
        $p = (!isset($args['page']) || $args['page'] <= 1 || $args['page'] > $nbPages) ? 1 : intval($args['page']);
        $offset = 20 * ($p - 1);
        // Generate paging links
        $pagination = Router::paginate($nbPages, $p, 'plugins/search?keywords='.Input::query('keywords').'/#');

        $plugins = PluginModel::getSearch(Input::query('keywords'));

        return View::setPageInfo([
                'plugins' => $plugins,
                'pagination' => $pagination,
                'title' => 'Search',
                'active_nav' => 'plugins',
                'top_right_link' => ['url' => Router::pathFor('plugins.create'), 'text' => 'Add plugin']
            ])
            ->addBreadcrumb([
                Router::pathFor('plugins') => 'Plugins',
                'Search results',
                '"'.Input::query('keywords').'"'
            ])
            ->addTemplate('plugins/index.php')
            ->display();
    }

}
