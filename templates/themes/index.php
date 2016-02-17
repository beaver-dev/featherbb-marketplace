<?php use \App\Core\Utils; ?>
<?php if (count($themes) == 0): ?>
        <div id="posterror" class="block">
            <h2><span>Oh noze !</span></h2>
            <div class="box">
                <div class="inbox error-info">
                    <p>No themes match your request. Want to see <a href="<?= Router::pathFor('themes'); ?>">all of them</a> ?</p>
                </div>
            </div>
        </div>
<?php else: ?>
        <div id="pl" class="blocktable">
            <h2><span><?= $title ?></span></h2>
            <div class="box">
                <div class="inbox">
                    <table>
                        <thead>
                            <tr>
                                <th class="tcl" scope="col">Theme</th>
                                <th class="tc2" scope="col">Downloads</th>
                                <th class="tcr" scope="col">Last version</th>
                            </tr>
                        </thead>
                        <tbody>
<?php foreach ($themes as $key => $theme): ?>
                            <tr class="<?= ($key % 2 == 0) ? 'rowodd' : 'roweven'; ?> theme-row">
                                <td class="tcl">
                                    <div class="icon"><div class="nosize">1</div></div>
                                    <div class="tclcon">
                                        <div>
                                            <h3><a href="<?= Router::pathFor('themes.view', ['name'=>$theme->vendor_name]); ?>"><?= htmlspecialchars($theme->name); ?></a>  <small class="byuser">by <a href="<?= Router::pathFor('themes.author', ['author'=>$theme->author]); ?>" title="View all user themes"><?= htmlspecialchars($theme->author); ?></a></small></h3>
                                            <div class="forumdesc"><?= isset($theme->description) ? htmlspecialchars($theme->description) : 'No description available'; ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="tc2"><?= htmlspecialchars($theme->nb_downloads); ?></td>
                                <td class="tcr">
                                    <a href="<?= Router::pathFor('themes.download', ['name'=>$theme->vendor_name,'version'=>$theme->last_version]); ?>" title="Download last version"><?= isset($theme->last_version) ? htmlspecialchars($theme->last_version) : ''; ?></a><br>
                                    <span><?= htmlspecialchars(Utils::format_time($theme->last_update, true)); ?></span>
                                </td>
                            </tr>
<?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
<?php endif; ?>
