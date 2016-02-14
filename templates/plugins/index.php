<?php if (count($plugins) == 0): ?>
        <div id="posterror" class="block">
            <h2><span>Oh noze !</span></h2>
            <div class="box">
                <div class="inbox error-info">
                    <p>No plugins match your request. Want to see <a href="<?= Router::pathFor('plugins'); ?>">all of them</a> ?</p>
                </div>
            </div>
        </div>
<?php else: ?>
        <div id="vf" class="blocktable">
            <h2><span><?= $title ?></span></h2>
            <div class="box">
                <div class="inbox">
                    <table>
                        <thead>
                            <tr>
                                <th class="tcl" scope="col">Plugin</th>
                                <th class="tc2" scope="col">Downloads</th>
                                <th class="tcr" scope="col">Last version</th>
                            </tr>
                        </thead>
                        <tbody>
<?php foreach ($plugins as $key => $plugin): ?>
                            <tr class="<?= ($key % 2 == 0) ? 'rowodd' : 'roweven'; ?> plugin-row">
                                <td class="tcl">
                                    <div class="icon"><div class="nosize">1</div></div>
                                    <div class="tclcon">
                                        <div>
                                            <h3><a href="<?= Router::pathFor('plugins.view', ['name'=>$plugin->vendor_name]); ?>"><?= htmlspecialchars($plugin->name); ?></a>  <small class="byuser">by <a href="<?= Router::pathFor('plugins.author', ['author'=>$plugin->author]); ?>" title="View all user plugins"><?= htmlspecialchars($plugin->author); ?></a></small></h3>
                                            <div class="forumdesc"><?= isset($plugin->description) ? htmlspecialchars($plugin->description) : 'No description available'; ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="tc2"><?= htmlspecialchars($plugin->nb_downloads); ?></td>
                                <td class="tcr">
                                    <a href="<?= Router::pathFor('plugins.download', ['name'=>$plugin->vendor_name,'version'=>$plugin->last_version]); ?>" title="Download last version"><?= isset($plugin->last_version) ? htmlspecialchars($plugin->last_version) : ''; ?></a>
                                    <span><?= htmlspecialchars($plugin->last_update); ?></span>
                                </td>
                            </tr>
<?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
<?php endif; ?>
