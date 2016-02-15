<?php namespace App\Controllers;

use ORM;

class BaseController {

    public function __construct($container) {
        $pendingPlugins = ORM::for_table('market_plugins')->where('status', 0)->count();
        // $pendingThemes = ORM::for_table('market_themes')->where('status', 0)->count();

        $stats = [
            'pendingPlugins' => $pendingPlugins,
            // 'pendingThemes' => $pendingThemes
        ];
        View::setPageInfo($stats);
    }

}
