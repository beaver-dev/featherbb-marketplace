<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, user-scalable=no, initial-scale=1" name="viewport">
    <meta content="noindex, follow" name="robots">
    <title>FeatherBB marketplace</title>
    <link href="/assets/style.css" type="text/css" rel="stylesheet">
    <link href="http://featherbb.org/forums/style/img/favicon.png" type="image/png" rel="shortcut icon">
    <link href="//cdnjs.cloudflare.com/ajax/libs/github-fork-ribbon-css/0.1.1/gh-fork-ribbon.min.css" rel="stylesheet">
</head>
<body id="punindex">
<div class="github-fork-ribbon-wrapper left">
    <div class="github-fork-ribbon">
        <a href="https://github.com/featherbb/featherbb">Fork me on GitHub</a>
    </div>
</div>
<header>
    <nav>
        <div class="container">
            <div id="phone-button" class="phone-menu">
                <a class="button-phone"></a>
            </div>
            <div id="phone">
                <div id="brdmenu" class="inbox">
                    <ul>
                        <li id="navindex" class="isactive">
                            <a href="<?= Router::pathFor('home') ?>">Home</a>
                        </li>
                        <li id="navuserlist">
                            <a href="<?= Router::pathFor('plugins') ?>">Plugins</a>
                        </li>
                        <li id="navsearch">
                            <a href="<?= Router::pathFor('home') ?>">Themes</a>
                        </li>
                        <li id="navprofile">
                            <a href="<?= Router::pathFor('home') ?>">Languages</a>
                        </li>
                    </ul>
                </div>
                <div class="navbar-right">
                    <form class="nav-search" action="/search" method="get">
                        <input type="hidden" value="search" name="action">
                        <input type="text" placeholder="Search" maxlength="100" size="20" name="keywords">
                    </form>
                </div>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="container-title-status">
            <h1 class="title-site">
                <a class="site-name" title="" href="">
                    <p>FeatherBB Marketplace</p>
                </a>
                <div id="brddesc">
                    <p>
                        <span>Lighter than a feather.</span>
                    </p>
                </div>
            </h1>
            <div class="status-avatar">
                <div id="brdwelcome" class="inbox">
                    <ul class="conl">
                        <li>
                            <span>Logged in as <strong>adaur</strong></span>
                        </li>
                        <li>
                            <span>Last visit: Yesterday 20:32:26</span>
                        </li>
                        <li class="reportlink">
                            <span><strong><a href="<?= Router::pathFor('plugins.pending'); ?>">View pending plugins</a></strong></span>
                        </li>
                    </ul>
                    <div class="clearer"></div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</header>
<section class="container">

    <div class="linkst">
        <div class="inbox crumbsplus">
<?php if(isset($breadcrumbs)): ?>
            <ul class="crumbs">
                <li><a href="<?= Router::pathFor('home'); ?>">Home</a></li>
<?php foreach($breadcrumbs as $url => $text): ?>
                <li><span>»&#160;</span><?= is_string($url) ? '<a href="'.$url.'">' : ''; ?><?php if($text == end($breadcrumbs)): echo '<strong>'.$text.'</strong>'; else: echo $text; endif; ?><?= is_string($url) ? '</a>' : ''; ?></li>
<?php endforeach; ?>
            </ul>
<?php endif; ?>
            <div class="pagepost">
    			<?php if(isset($pagination)): ?><p class="pagelink conl"><span class="pages-label">Pages: </span><strong class="item1">1</strong> <a href="/topic/62/featherbb-v100-beta-1/page/2/">2</a> <a href="/topic/62/featherbb-v100-beta-1/page/3/">3</a> <a href="/topic/62/featherbb-v100-beta-1/page/4/">4</a> <a rel="next" href="/topic/62/featherbb-v100-beta-1/page/2/">Next</a></p><?php endif; ?>
                <?php if(isset($top_right_link)): ?><p class="postlink conr"><a href="<?= $top_right_link['url']; ?>"><?= $top_right_link['text']; ?></a></p><?php endif; ?>
            </div>
            <div class="clearer"></div>
        </div>
    </div>

    <div id="brdmain">
