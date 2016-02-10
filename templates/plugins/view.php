<div class="plugin-head">
    <h3><?= $plugin->name; ?></h3>
    <small><?= $plugin->nb_downloads; ?> downloads</small>
    <div class="row">
        <div class="six columns">
            <em><?= isset($plugin->description) ? $plugin->description : 'No description available'; ?></em>
        </div>
        <div class="six columns">
            <a href="<?= Router::pathFor('plugins.download', ['name'=>$plugin->vendor_name]); ?>" class="button u-pull-right">Download</a>
        </div>
    </div>
    <ul id="plugin-nav" class="inline">
<?php foreach($plugin->menus as $menu): ?>
        <li>
            <a href="<?= Router::pathFor('plugins.view', ['name'=>$plugin->vendor_name, 'action'=>strtolower($menu)]); ?>"><?= $menu; ?></a>
        </li>
<?php endforeach; ?>
        <li>
            <a href="<?= Router::pathFor('plugins.view', ['name'=>$plugin->vendor_name, 'action'=>'history']); ?>">History</a>
        </li>
    </ul>
</div>

<div class="plugin-body">
    <?= $content; ?>
</div>
<?php
$tag_links = [];
foreach ($plugin->keywords as $tag) {
    $tag_links[] = '<a href="'.Router::pathFor('plugins.tags', ['tag' => str_replace([' ', '.'], '-', $tag)]).'">'.$tag.'</a>';
}
?>
<div class="plugin-footer">
    Tags: <?= implode(', ', $tag_links); ?>
</div>
