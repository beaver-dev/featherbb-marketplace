<?php namespace App\Controllers;

use ORM;
use App\Models\Plugin as PluginModel;
use App\Models\Github as GithubApi;
// use Model;

class PluginsController {

    public function find($req, $res, $args)
    {
        $lastPlugins = PluginModel::getLatests();
        // $data = GithubApi::getComposerData('private-messages');

        return View::setPageInfo(['lastPlugins' => $lastPlugins])
            ->addBreadcrumb(['plugins'])
            ->addTemplate('plugins/index.php')
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
        $id = Request::getParsedBody()['plugin_id'];
        $homepage = Request::getParsedBody()['homepage'];
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

    public function pending($req, $res, $args)
    {
        $pendingPlugins = PluginModel::getPending();
        // $data = GithubApi::getComposerData('private-messages');

        return View::setPageInfo(['plugins' => $pendingPlugins])
            ->addBreadcrumb(['plugins'])
            ->addTemplate('plugins/pending.php')
            ->display();
    }

}
