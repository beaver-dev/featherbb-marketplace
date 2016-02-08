<div class="plugin-head">
    <h3><?= $plugin->name; ?></h3>
    <ul id="plugin-nav" class="inline">
<?php foreach($plugin->menus as $menu): ?>
        <li>
            <a href="<?= Router::pathFor('plugins.view', ['name'=>$plugin->vendor_name, 'action'=>strtolower($menu)]); ?>"><?= $menu; ?></a>
        </li>
<?php endforeach; ?>
    </ul>
</div>

<?= $markdown; ?>
