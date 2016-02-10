        <div id="vf" class="blocktable">
            <h2><span>Plugins</span></h2>
            <div class="box">
                <div class="inbox">
                    <table>
                        <thead>
                            <tr>
                                <th class="tcl" scope="col">Plugin</th>
                                <th class="tc2" scope="col">Downloads</th>
                                <th class="tcr" scope="col">Version</th>
                            </tr>
                        </thead>
                        <tbody>
<?php foreach ($lastPlugins as $key => $plugin): ?>
                            <tr class="<?= ($key % 2 == 0) ? 'rowodd' : 'roweven'; ?> plugin-row">
                                <td class="tcl">
                                    <div class="icon"><div class="nosize">1</div></div>
                                    <div class="tclcon">
                                        <div>
                                            <h3><a href="<?= Router::pathFor('plugins.view', ['name'=>$plugin->vendor_name]); ?>"><?= $plugin->name; ?></a>  <small class="byuser">by <?= $plugin->author; ?></small></h3>
                                            <div class="forumdesc"><?= isset($plugin->description) ? $plugin->description : 'No description available'; ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="tc2"><?= $plugin->nb_downloads; ?></td>
                                <td class="tcr">
                                    <a href="/post/175/#p175"><?= isset($plugin->last_version) ? $plugin->last_version : '0.1.0'; ?></a>
                                    <span><?= $plugin->last_update; ?></span>
                                </td>
                            </tr>
<?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
