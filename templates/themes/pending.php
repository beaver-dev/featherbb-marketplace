<script type="text/javascript">
    function setVendorName(vendor_name) {
        var vendorInput = document.getElementById('vendor_name');
        vendorInput.value = vendor_name;
    }
</script>
<form id="accept-form" action="<?= Router::pathFor('themes.accept'); ?>" method="post">
    <input type="hidden" name="csrf_name" value="<?= $csrf_name; ?>">
    <input type="hidden" name="csrf_value" value="<?= $csrf_value; ?>">

    <div>
        <input type="text" name="vendor_name" id="vendor_name" value="" placeholder="Vendor name" width="80">
        <input type="submit" name="accept_theme" value="Accept" />
        <input type="submit" name="delete_theme" value="Delete" />
    </div>
    <div>
<?php foreach ($themes as $key => $theme): ?>
        <input type="radio" name="theme_id" value="<?= $theme->id; ?>" onclick="setVendorName('<?= $theme->vendor_name; ?>')">
        <a href="<?= $theme->homepage; ?>" target="_blank"><?= $theme->name; ?></a> <br>
<?php endforeach; ?>
    </div>
</form>
