        <div id="vf" class="blocktable">
            <h2><span><?= $title ?></span></h2>
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
                                            <h3><a href="<?= Router::pathFor('plugins.view', ['name'=>$plugin->vendor_name]); ?>"><?= htmlspecialchars($plugin->name); ?></a>  <small class="byuser">by <a href="<?= Router::pathFor('plugins.author', ['author'=>$plugin->author]); ?>"><?= htmlspecialchars($plugin->author); ?></a></small></h3>
                                            <div class="forumdesc"><?= isset($plugin->description) ? htmlspecialchars($plugin->description) : 'No description available'; ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="tc2"><?= htmlspecialchars($plugin->nb_downloads); ?></td>
                                <td class="tcr">
                                    <a href=""><?= isset($plugin->last_version) ? htmlspecialchars($plugin->last_version) : ''; ?></a>
                                    <span><?= htmlspecialchars($plugin->last_update); ?></span>
                                </td>
                            </tr>
<?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
