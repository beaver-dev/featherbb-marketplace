            <h3>Pending plugins</h3>
            <!-- Use this form to update plugin data -->
            <form id="accept-form" action="<?= Router::pathFor('plugins.accept'); ?>" method="post">
                <input type="hidden" name="csrf_name" value="<?= $csrf_name; ?>">
                <input type="hidden" name="csrf_value" value="<?= $csrf_value; ?>">
            </form>
            <!-- Display pending plugins in review queue -->
            <table class="u-full-width">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>New URL</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
<?php foreach ($plugins as $plugin): ?>
                    <tr>
                        <td>
                            <a href="<?= $plugin->homepage; ?>" target="_blank"><?= $plugin->name; ?></a>
                        </td>
                        <td>
                            <input class="u-full-width" type="url" name="homepage" form="accept-form" value="https://github.com/featherbb/private-messages">
                            <input type="hidden" name="plugin_id" value="<?= $plugin->id; ?>" form="accept-form">
                        </td>
                        <td>
                            <button type="submit" name="submit" form="accept-form" class="">&#10003;</button>
                        </td>
                    </tr>
<?php endforeach; ?>
                </tbody>
            </table>
