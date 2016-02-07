            <a href="<?= Router::pathFor('plugins.create', ['type' => 'plugin']) ?>">Add plugin</a>

            <div class="row">
<?php foreach ($lastPlugins as $plugin): ?>
                <div class="six columns">
                    <div class="plugin-card">
                        <div class="plugin-card-top">
                            <a href="https://wordpress.org/plugins/jetpack/" class="plugin-icon"><style type='text/css'>#plugin-icon-jetpack { width:128px; height:128px; background-image: url(//ps.w.org/jetpack/assets/icon-128x128.png?rev=1279667); background-size:128px 128px; }@media only screen and (-webkit-min-device-pixel-ratio: 1.5) { #plugin-icon-jetpack { background-image: url(//ps.w.org/jetpack/assets/icon-256x256.png?rev=1279667); } }</style><div class='plugin-icon' id='plugin-icon-jetpack' style='float:left; margin: 3px 6px 6px 0px;'></div></a>
                            <div class="name column-name">
                                <h4><a href="<?= Router::pathFor('plugins.view', ['name'=>$plugin->vendor_name]); ?>"><?= $plugin->name; ?></a></h4>
                            </div>
                            <div class="desc column-description">
                                <p><?= $plugin->description; ?></p>
                                <p class="authors"><cite>By: <a href='//profiles.wordpress.org/automattic/'>Automattic</a>, <a href='//profiles.wordpress.org/aduth/'>aduth</a>, <a href='//profiles.wordpress.org/akirk/'>Alex Kirk</a>, <a href='//profiles.wordpress.org/allendav/'>allendav</a>, <a href='//profiles.wordpress.org/alternatekev/'>alternatekev</a>, <a href='//profiles.wordpress.org/andy/'>Andy Skelton</a>, and others.</cite></p>
                            </div>
                        </div>

                        <div class="plugin-card-bottom">
                            <div class="vers column-rating">
                                <div class='wporg-ratings' title='4 out of 5 stars' style='color:#ffb900;'><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-empty"></span></div>			<span class="num-ratings" title="Rating based on 812 reviews">(812)</span>
                            </div>
                            <div class="column-updated">
                                <strong>Last Updated:</strong>
                                <span title="2016-1-21">2 weeks ago</span>
                            </div>
                            <div class="column-installs">
                                1+ million active installs
                            </div>
                            <div class="column-compatibility">
                                <strong>Compatible up to:</strong>
                                <span class="compatibility">4.4.2</span>
                            </div>
                        </div>
                    </div>
                </div>
<?php endforeach; ?>
            </div>
