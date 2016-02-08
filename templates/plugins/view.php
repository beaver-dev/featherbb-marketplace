<div class="plugin-head">
    <h3><?= $plugin->name; ?></h3>
    <small><?= $plugin->nb_downloads; ?> downloads</small>
    <div class="row">
        <div class="six columns">
            <?= $plugin->description; ?>de
        </div>
        <div class="six columns">
            <a href="<?= Router::pathFor('plugins.download', ['name'=>$plugin->vendor_name]); ?>" class="button u-pull-right">Download version <?= $plugin->last_version; ?></a>
        </div>
    </div>
    <ul id="plugin-nav" class="inline">
<?php foreach($plugin->menus as $menu): ?>
        <li>
            <a href="<?= Router::pathFor('plugins.view', ['name'=>$plugin->vendor_name, 'action'=>strtolower($menu)]); ?>"><?= $menu; ?></a>
        </li>
<?php endforeach; ?>
    </ul>
</div>

<?= $markdown; ?>
