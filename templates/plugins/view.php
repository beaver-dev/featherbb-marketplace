<?php
$tag_links = [];
foreach ($plugin->keywords as $tag) {
    $tag_links[] = '<a href="'.Router::pathFor('plugins.tags', ['tag' => str_replace([' ', '.'], '-', $tag)]).'">#'.htmlspecialchars($tag).'</a>';
}
?>
<div class="linksb">
	<div class="inbox crumbsplus">
		<p class="subscribelink clearb">
            <a href="https://github.com/featherbb/<?= $plugin->vendor_name; ?>" target="_blank">Homepage</a>
            <a href="<?= Router::pathFor('plugins.download', ['name'=>$plugin->vendor_name]); ?>" title="Download last version">Download</a>
<?php if($user->is_admmod || $plugin->author == $user->username): ?>
            <a href="<?= Router::pathFor('plugins.update', ['name'=>$plugin->vendor_name]); ?>" title="Update from Github">Update</a>
<?php endif; ?>
        </p>
	</div>
</div>

<div class="light-bg">
    <div class="plugin-head">
        <h2>
            <a href="<?= Router::pathFor('plugins.view', ['name'=>$plugin->vendor_name]); ?>"><?= $plugin->name; ?></a>
            <small><?= isset($plugin->last_version) ? htmlspecialchars($plugin->last_version) : '0.1.0'; ?></small>
            <span class="plugin-last-update">Last updated: <?= $plugin->last_update; ?></span>
        </h2>

        <em><?= isset($plugin->description) ? htmlspecialchars($plugin->description) : 'No description available'; ?></em>
        <p><?= htmlspecialchars($plugin->nb_downloads); ?> downloads</p>
        <p><?= implode(', ', $tag_links); ?></p>
    </div>

    <div id="plugin-nav">
    <?php foreach($plugin->menus as $menu): ?>
        <a class="button <?= ($active_menu == strtolower($menu)) ? 'button-primary' : ''; ?>" href="<?= Router::pathFor('plugins.view', ['name'=>$plugin->vendor_name, 'action'=>strtolower($menu)]); ?>"><?= htmlspecialchars($menu); ?></a>
    <?php endforeach; ?>
    </div>

    <div class="plugin-body">
        <?= $content; ?>
        <p class="postedit"><em>Last edited by blade (Today 15:28:47)</em></p>
    </div>
</div>

<div class="linksb">
	<div class="inbox crumbsplus">
		<p class="subscribelink clearb">
            <a href="https://github.com/featherbb/<?= $plugin->vendor_name; ?>" target="_blank">Homepage</a>
            <a href="<?= Router::pathFor('plugins.download', ['name'=>$plugin->vendor_name]); ?>" title="Download last version">Download</a>
<?php if($user->is_admmod || $plugin->author == $user->username): ?>
            <a href="<?= Router::pathFor('plugins.update', ['name'=>$plugin->vendor_name]); ?>" title="Update from Github">Update</a>
<?php endif; ?>
        </p>
	</div>
</div>
