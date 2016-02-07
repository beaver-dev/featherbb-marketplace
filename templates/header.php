<html>
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>FeatherBB Marketplace</title>
        <link href='//fonts.googleapis.com/css?family=Raleway:400,300,600' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="/assets/style/normalize.css">
        <link rel="stylesheet" href="/assets/style/skeleton.css">
        <link rel="stylesheet" href="/assets/style/custom.css">
    </head>
    <body>
        <nav class="navbar">
            <div class="container">
                <ul id="navbar-list">
                    <li class="navbar-item"><a href="<?= Router::pathFor('home') ?>">Home</a></li>
                    <li class="navbar-item"><a href="<?= Router::pathFor('plugins') ?>">Plugins</a></li>
                    <li class="navbar-item"><a href="<?= Router::pathFor('home') ?>">Themes</a></li>
                    <li class="navbar-item"><a href="<?= Router::pathFor('home') ?>">Languages</a></li>
                </ul>
            </div>
        </nav>
        <div id="content" class="container">

<?php if (isset($breadcrumbs)): ?>
            <div class="linkst">
            	<div class="inbox">
            		<ul class="crumbs">
<?php foreach ($breadcrumbs as $url => $text): ?>
                        <li><span>»&#160;</span><?= is_string($url) ? "<a href=\"$url\">" : '<strong>' ?><?= $text ?><?= is_string($url) ? "</a>" : '</strong>' ?></li>
<?php endforeach; ?>
            		</ul>
            	</div>
            </div>
<?php endif; ?>
