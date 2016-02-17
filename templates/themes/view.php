<?php
use \App\Core\Utils;
$tag_links = [];
foreach ($theme->keywords as $tag) {
    $tag_links[] = '<a href="'.Router::pathFor('themes.tags', ['tag' => str_replace([' ', '.'], '-', $tag)]).'">#'.htmlspecialchars($tag).'</a>';
}
?>
<div class="linksb">
	<div class="inbox crumbsplus">
		<p class="subscribelink clearb">
            <a href="<?= $theme->homepage; ?>" target="_blank">Homepage</a>
            <a href="<?= Router::pathFor('themes.download', ['name'=>$theme->vendor_name]); ?>" title="Download last version">Download</a>
<?php if($user->is_admmod || $theme->author == $user->username): ?>
            <a href="<?= Router::pathFor('themes.update', ['name'=>$theme->vendor_name]); ?>" title="Update from Github">Update</a>
<?php endif; ?>
        </p>
	</div>
</div>

<div class="light-bg">
    <div class="plugin-head">
        <h2>
            <a href="<?= Router::pathFor('themes.view', ['name'=>$theme->vendor_name]); ?>"><?= $theme->name; ?></a>
            <small><?= isset($theme->last_version) ? htmlspecialchars($theme->last_version) : '0.1.0'; ?></small>
            <span class="plugin-last-update">Last updated: <?= htmlspecialchars(Utils::format_time($theme->last_update)); ?></span>
        </h2>

        <p>By <?= htmlspecialchars($theme->author); ?></p>
        <p><?= htmlspecialchars($theme->nb_downloads); ?> downloads</p>
        <p><?= implode(', ', $tag_links); ?></p>
    </div>

    <div class="theme-body">
        <?= $content; ?>
    </div>
</div>

<div class="linksb">
	<div class="inbox crumbsplus">
		<p class="subscribelink clearb">
            <a href="<?= $theme->homepage; ?>" target="_blank">Homepage</a>
            <a href="<?= Router::pathFor('themes.download', ['name'=>$theme->vendor_name]); ?>" title="Download last version">Download</a>
<?php if($user->is_admmod || $theme->author == $user->username): ?>
            <a href="<?= Router::pathFor('themes.update', ['name'=>$theme->vendor_name]); ?>" title="Update from Github">Update</a>
<?php endif; ?>
        </p>
	</div>
</div>
