<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, user-scalable=no, initial-scale=1" name="viewport">
    <meta content="noindex, follow" name="robots">
    <title>FeatherBB Marketplace</title>
    <link href="/assets/style.css" type="text/css" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="http://featherbb.org/favicon.png"/>
    <link href="http://featherbb.org/forums/style/img/favicon.png" type="image/png" rel="shortcut icon">
    <link href="//cdnjs.cloudflare.com/ajax/libs/github-fork-ribbon-css/0.1.1/gh-fork-ribbon.min.css" rel="stylesheet">
</head>
<body id="punindex">
<div class="github-fork-ribbon-wrapper left">
    <div class="github-fork-ribbon">
        <a href="https://github.com/beaver-dev/featherbb-marketplace" target="_blank">Fork me on GitHub</a>
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
                        <li id="navindex"<?php if(isset($active_nav) && $active_nav == 'index') echo ' class="isactive"'; ?>>
                            <a href="<?= Router::pathFor('home') ?>">Home</a>
                        </li>
                        <li id="navplugins"<?php if(isset($active_nav) && $active_nav == 'plugins') echo ' class="isactive"'; ?>>
                            <a href="<?= Router::pathFor('plugins') ?>">Plugins</a>
                        </li>
                        <li id="navthemes"<?php if(isset($active_nav) && $active_nav == 'themes') echo ' class="isactive"'; ?>>
                            <a href="<?= Router::pathFor('home') ?>">Themes</a>
                        </li>
                        <li id="navforum">
                            <a href="http://forums.featherbb.org" target="_blank">Forum</a>
                        </li>
<?php if($user->is_guest): ?>
                        <li id="navlogin"<?php if(isset($active_nav) && $active_nav == 'login') echo ' class="isactive"'; ?>>
                            <a href="<?= Router::pathFor('login') ?>">Login</a>
                        </li>
<?php else: ?>
                        <li id="navlogout">
                            <a href="<?= Router::pathFor('logout') ?>">Logout</a>
                        </li>
<?php endif; ?>
                    </ul>
                </div>
                <div class="navbar-right">
                    <form class="nav-search" action="/plugins/search" method="get">
                        <input type="text" placeholder="Search" maxlength="100" size="20" name="keywords" value="<?= Input::query('keywords'); ?>">
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
<?php if(!$user->is_guest): ?>
                        <li>
                            <span>Logged in as <strong><?= $user->username; ?></strong></span>
                        </li>
<?php if($user->is_admmod && $pendingPlugins > 0): ?>
                        <li class="pendinglink">
                            <span><strong><a href="<?= Router::pathFor('plugins.pending'); ?>"><?= $pendingPlugins ?> pending plugins</a></strong></span>
                        </li>
<?php endif; ?>
<?php else: ?>
                        <li>
                            <span>You are not logged in.</span>
                        </li>
<?php endif; ?>
                    </ul>
                    <div class="clearer"></div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
<?php if (!empty(Container::get('flash')->getMessages())): ?>
    <script type="text/javascript">
        window.onload = function() {
            var flashMessage = document.getElementById('flashmsg');
            flashMessage.className = 'flashmsg '+flashMessage.getAttribute('data-type')+' show';
            setTimeout(function () {
                flashMessage.className = 'flashmsg '+flashMessage.getAttribute('data-type');
            }, 10000);
            return false;
        }
    </script>
<?php foreach (Container::get('flash')->getMessages() as $type => $message): ?>
    <div class="flashmsg info" data-type="<?= $type; ?>" id="flashmsg">
        <h2>Info <span style="float:right;cursor:pointer" onclick="document.getElementById('flashmsg').className = 'flashmsg';">&times;</span></h2>
        <p><?= htmlspecialchars($message[0]) ?></p>
    </div>
<?php endforeach; ?>
<?php endif; ?>
</header>
<section class="container">

    <div class="linkst">
        <div class="inbox crumbsplus">
<?php if(isset($breadcrumbs)): ?>
            <ul class="crumbs">
                <li><a href="<?= Router::pathFor('home'); ?>">Home</a></li>
<?php foreach($breadcrumbs as $url => $text): ?>
                <li><span>»&#160;</span><?= is_string($url) ? '<a href="'.$url.'">' : ''; ?><?php if($text == end($breadcrumbs) || !is_string($url)): echo '<strong>'.$text.'</strong>'; else: echo $text; endif; ?><?= is_string($url) ? '</a>' : ''; ?></li>
<?php endforeach; ?>
            </ul>
<?php endif; ?>
            <div class="pagepost">
    			<?php if(isset($pagination)): ?><p class="pagelink conl"><?= $pagination; ?></p><?php endif; ?>
                <?php if(isset($top_right_link)): ?><p class="postlink conr"><a href="<?= $top_right_link['url']; ?>"><?= $top_right_link['text']; ?></a></p><?php endif; ?>
            </div>
            <div class="clearer"></div>
        </div>
    </div>

    <div id="brdmain">
