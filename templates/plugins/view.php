<?php
$tag_links = [];
foreach ($plugin->keywords as $tag) {
    $tag_links[] = '<a href="'.Router::pathFor('plugins.tags', ['tag' => str_replace([' ', '.'], '-', $tag)]).'">#'.htmlspecialchars($tag).'</a>';
}
?>
<div class="light-bg">
    <div class="plugin-head">
        <h2><a href="#"><?= $plugin->name; ?></a> <small><?= isset($plugin->last_version) ? htmlspecialchars($plugin->last_version) : '0.1.0'; ?></small></h2>
        <em><?= isset($plugin->description) ? htmlspecialchars($plugin->description) : 'No description available'; ?></em>
        <p><?= htmlspecialchars($plugin->nb_downloads); ?> downloads</p>
        <p><?= implode(', ', $tag_links); ?></p>
    </div>

    <div id="plugin-nav">
        <a class="button" href="<?= Router::pathFor('plugins.download', ['name'=>$plugin->vendor_name]); ?>">Download</a>
    <?php foreach($plugin->menus as $menu): ?>
        <a class="button" href="<?= Router::pathFor('plugins.view', ['name'=>$plugin->vendor_name, 'action'=>strtolower($menu)]); ?>"><?= htmlspecialchars($menu); ?></a>
    <?php endforeach; ?>
    </div>

    <div class="plugin-body">
        <?= $content; ?>
    </div>
</div>
