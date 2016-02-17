<?php namespace App\Controllers;

use ORM;
use Michelf\Markdown;
use App\Models\Theme as ThemeModel;
use App\Models\Github as GithubApi;

class ThemesController extends BaseController {

    public function index($req, $res, $args)
    {
        // Get number of pages
        $nbThemes = ORM::for_table('market_themes')->where('status', 2)->count();
        $nbPages = ceil(($nbThemes + 1) / 20);
        // Determine the offset
        $p = (!isset($args['page']) || $args['page'] <= 1 || $args['page'] > $nbPages) ? 1 : intval($args['page']);
        $offset = 20 * ($p - 1);
        // Generate paging links
        $pagination = Router::paginate($nbPages, $p, 'themes/#');

        $themes = ThemeModel::getIndex($offset);

        return View::setPageInfo([
                'themes' => $themes,
                'pagination' => $pagination,
                'title' => 'Themes',
                'active_nav' => 'themes',
                'top_right_link' => ['url' => Router::pathFor('themes.create'), 'text' => 'Add theme']
            ])
            ->addBreadcrumb(['Themes'])
            ->addTemplate('themes/index.php')
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

        $pendingThemes = ThemeModel::getPending();

        return View::setPageInfo([
                'themes' => $pendingThemes,
                'active_nav' => 'themes',
                'title' => 'Pending plugins'
            ])
            ->addBreadcrumb([
                Router::pathFor('themes') => 'Themes',
                'Pending'
            ])
            ->addTemplate('themes/pending.php')
            ->display();
    }

    public function create($req, $res, $args)
    {
        // Ensure user is logged
        $user = $req->getAttribute('user');
        if ($user->is_guest) {
            return Router::redirect(Router::pathFor('login'), 'You must be logged in to submit a new theme');
        }

        // Prepare base data to send to view
        $data = ['active_nav' => 'themes'];
        if (Request::isPost()) {
            $theme = [
                'homepage' => Input::post('homepage'),
                'name' => Input::post('name'),
                'author' => $user->username
            ];
            ThemeModel::create($theme);
            return Router::redirect(Router::pathFor('themes.create'), 'Theme submitted');
        }
        // Display view
        return View::setPageInfo($data)
            ->addBreadcrumb([
                Router::pathFor('themes') => 'Themes',
                'Submit new theme'
            ])
            ->addTemplate('themes/create.php')
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
        $theme_id = Input::post('theme_id');

        // Check required fields are sent from form
        if (!$vendor_name || !$theme_id) {
            $notFoundHandler = Container::get('notFoundHandler');
            return $notFoundHandler($req, $res);
        }

        // Check vendor name is unique
        if (ORM::for_table('market_themes')->where('vendor_name', $vendor_name)->where('status', 2)->count() > 0) {
            return 'Vendor name already exists!';
        }

        if (Input::post('accept_theme')) {
            // If no errors while getting data from Github, store generic infos to DB, else throw 404
            if (ThemeModel::downloadData($theme_id, $vendor_name) === false) {
                $notFoundHandler = Container::get('notFoundHandler');
                return $notFoundHandler($req, $res);
            }
        } elseif (Input::post('delete_theme')) {
            // TODO: Remove theme from DB
        }

        return Router::redirect(Router::pathFor('themes.pending'));
    }

    public function view($req, $res, $args)
    {
        $theme = ThemeModel::getData($args['name']);

        if ($theme === false) {
            $notFoundHandler = Container::get('notFoundHandler');
            return $notFoundHandler($req, $res);
        }

        $content = Markdown::defaultTransform(htmlspecialchars($theme->readme));

        return View::setPageInfo(['theme' => $theme, 'content' => $content, 'active_nav' => 'themes'])
            ->addBreadcrumb([
                Router::pathFor('themes') => 'Themes',
                htmlspecialchars($theme->name)
            ])
            ->addTemplate('themes/view.php')
            ->display();
    }

    public function update($req, $res, $args)
    {
        $theme = ThemeModel::getData($args['name']);
        $user = $req->getAttribute('user');

        // Ensure plugin exists and user has rights to update it
        if (!$theme || ($theme->author != $user->username && !$user->is_admmod)) {
            $notFoundHandler = Container::get('notFoundHandler');
            return $notFoundHandler($req, $res);
        }

        ThemeModel::downloadData($theme->id, $theme->vendor_name);

        return Router::redirect(Router::pathFor('themes.view', ['name' => $theme->vendor_name]), 'Theme updated!');
    }

    public function download($req, $res, $args)
    {
        $theme = ThemeModel::getData($args['name']);

        if (!$theme) {
            $notFoundHandler = Container::get('notFoundHandler');
            return $notFoundHandler($req, $res);
        }

        $theme->nb_downloads = $theme->nb_downloads+1;
        $theme->save();
        $version = isset($args['version']) ? $args['version'] : 'master';
        return Router::redirect('https://api.github.com/repos/featherbb/'.$theme->vendor_name.'/zipball/'.$version);
    }

    public function tags($req, $res, $args)
    {
        // Get number of pages
        $nbThemes = ThemeModel::countGetTags($args['tag']);
        $nbPages = ceil(($nbThemes + 1) / 20);
        // Determine the offset
        $p = (!isset($args['page']) || $args['page'] <= 1 || $args['page'] > $nbPages) ? 1 : intval($args['page']);
        $offset = 20 * ($p - 1);
        // Generate paging links
        $pagination = Router::paginate($nbPages, $p, 'themes/tags/'.$args['tag'].'/#');

        $themes = ThemeModel::getTags($args['tag'], $offset);

        return View::setPageInfo([
                'themes' => $themes,
                'pagination' => $pagination,
                'title' => 'Tags',
                'active_nav' => 'themes',
                'top_right_link' => ['url' => Router::pathFor('themes.create'), 'text' => 'Add theme']
            ])
            ->addBreadcrumb([
                Router::pathFor('themes') => 'Themes',
                'Search by tags'
            ])
            ->addTemplate('themes/index.php')
            ->display();
    }

    public function author($req, $res, $args)
    {
        // Get number of pages
        $nbThemes = ThemeModel::countGetAuthor($args['author']);
        $nbPages = ceil(($nbThemes + 1) / 20);
        // Determine the offset
        $p = (!isset($args['page']) || $args['page'] <= 1 || $args['page'] > $nbPages) ? 1 : intval($args['page']);
        $offset = 20 * ($p - 1);
        // Generate paging links
        $pagination = Router::paginate($nbPages, $p, 'themes/author/'.$args['author'].'/#');

        $themes = ThemeModel::getAuthor($args['author']);

        return View::setPageInfo([
                'themes' => $themes,
                'pagination' => $pagination,
                'title' => 'Author',
                'active_nav' => 'themes',
                'top_right_link' => ['url' => Router::pathFor('themes.create'), 'text' => 'Add theme']
            ])
            ->addBreadcrumb([
                Router::pathFor('themes') => 'Themes',
                'Authored by '.htmlspecialchars($args['author'])
            ])
            ->addTemplate('themes/index.php')
            ->display();
    }

    public function search($req, $res, $args)
    {
        if (!Input::query('keywords')) {
            return Router::redirect(Router::pathFor('themes'));
        }

        // Get number of pages
        $nbThemes = ThemeModel::countGetSearch(Input::query('keywords'));
        $nbPages = ceil(($nbThemes + 1) / 20);
        // Determine the offset
        $p = (!isset($args['page']) || $args['page'] <= 1 || $args['page'] > $nbPages) ? 1 : intval($args['page']);
        $offset = 20 * ($p - 1);
        // Generate paging links
        $pagination = Router::paginate($nbPages, $p, 'themes/search?keywords='.Input::query('keywords').'/#');

        $themes = ThemeModel::getSearch(Input::query('keywords'));

        return View::setPageInfo([
                'themes' => $themes,
                'pagination' => $pagination,
                'title' => 'Search',
                'active_nav' => 'themes',
                'top_right_link' => ['url' => Router::pathFor('themes.create'), 'text' => 'Add theme']
            ])
            ->addBreadcrumb([
                Router::pathFor('themes') => 'Themes',
                'Search results',
                '"'.Input::query('keywords').'"'
            ])
            ->addTemplate('themes/index.php')
            ->display();
    }

}
