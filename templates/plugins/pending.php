<script type="text/javascript">
    function setVendorName(vendor_name) {
        var vendorInput = document.getElementById('vendor_name');
        vendorInput.value = vendor_name;
    }
</script>
<form id="accept-form" action="<?= Router::pathFor('plugins.accept'); ?>" method="post">
    <input type="hidden" name="csrf_name" value="<?= $csrf_name; ?>">
    <input type="hidden" name="csrf_value" value="<?= $csrf_value; ?>">

    <div>
        <input type="text" name="vendor_name" id="vendor_name" value="" placeholder="Vendor name" width="80">
        <input type="submit" name="accept_plugin" value="Accept" />
        <input type="submit" name="delete_plugin" value="Delete" />
    </div>
    <div>
<?php foreach ($plugins as $key => $plugin): ?>
        <input type="radio" name="plugin_id" value="<?= $plugin->id; ?>" onclick="setVendorName('<?= $plugin->vendor_name; ?>')">
        <a href="<?= $plugin->homepage; ?>" target="_blank"><?= $plugin->name; ?></a> <br>
<?php endforeach; ?>
    </div>
</form>


        <!-- Use this form to update plugin data -->
        <!-- <form id="accept-form" action="<?= Router::pathFor('plugins.accept'); ?>" method="post">
            <input type="hidden" name="csrf_name" value="<?= $csrf_name; ?>">
            <input type="hidden" name="csrf_value" value="<?= $csrf_value; ?>">
            <div class="linksb">
                <div class="inbox crumbsplus">
                    <div class="pagepost">
                        <p class="conr modbuttons"><input type="submit" name="accept_plugins" value="Accept" /> <input type="submit" name="delete_plugins" value="Delete" /></p>
                        <div class="clearer"></div>
                    </div>
                </div>
            </div>
            <div id="vf" class="blocktable">
                <h2><span>Pending plugins</span></h2>
                <div class="box">
                    <div class="inbox">
                        <table>
                            <thead>
                                <tr>
                                    <th class="tcl" scope="col">Name</th>
                                    <th class="tcr" scope="col">Vendor name</th>
                                    <th class="tc2" scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
<?php foreach ($plugins as $key => $plugin): ?>
                                <tr class="<?= ($key % 2 == 0) ? 'rowodd' : 'roweven'; ?> plugin-row">
                                    <td class="tcl">
                                        <input type="checkbox" name="plugin_id[<?= $plugin->id; ?>]" value="<?= $plugin->vendor_name; ?>" form="accept-form">
                                        <a href="<?= $plugin->homepage; ?>" target="_blank"><?= $plugin->name; ?></a>
                                    </td>
                                    <td class="tcr">
                                        <?= $plugin->vendor_name; ?>
                                    </td>
                                </tr>
<?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="linksb">
                <div class="inbox crumbsplus">
                    <div class="pagepost">
                        <p class="conr modbuttons"><input type="submit" name="accept_plugins" value="Accept" /> <input type="submit" name="delete_plugins" value="Delete" /></p>
                        <div class="clearer"></div>
                    </div>
                </div>
            </div>
        </form> -->
