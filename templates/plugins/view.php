<?php
$tag_links = [];
foreach (explode(',',$plugin->keywords) as $tag) {
    $tag_links[] = '<a href="'.Router::pathFor('plugins.tags', ['tag' => str_replace([' ', '.'], '-', $tag)]).'">#'.$tag.'</a>';
}
?>
<div class="plugin-head">
    <h2><a href="#"><?= $plugin->name; ?></a> <small><?= isset($plugin->last_version) ? $plugin->last_version : '0.1.0'; ?></small></h2>
    <em><?= isset($plugin->description) ? $plugin->description : 'No description available'; ?></em>
    <p><?= $plugin->nb_downloads; ?> downloads</p>
    <p><?= implode(', ', $tag_links); ?></p>
</div>

<div id="plugin-nav">
    <a class="button" href="<?= Router::pathFor('plugins.download', ['name'=>$plugin->vendor_name]); ?>">Download</a>
<?php foreach($plugin->menus as $menu): ?>
    <a class="button" href="<?= Router::pathFor('plugins.view', ['name'=>$plugin->vendor_name, 'action'=>strtolower($menu)]); ?>"><?= $menu; ?></a>
<?php endforeach; ?>
</div>

<div class="plugin-body">
    <?= $content; ?>
</div>
