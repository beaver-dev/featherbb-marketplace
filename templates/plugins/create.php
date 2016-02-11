<?php if (isset($errors)): ?>
            <div id="posterror" class="block">
            	<h2><span>Post errors</span></h2>
            	<div class="box">
            		<div class="inbox error-info">
            			<p>The following errors need to be corrected before the message can be posted:</p>
            			<ul class="error-list">
<?php foreach ($errors as $error): ?>
            				<li><strong><?= $error; ?></strong></li>
<?php endforeach; ?>
            			</ul>
            		</div>
            	</div>
            </div>
<?php endif; ?>

            <div id="postform" class="blockform">
            	<h2><span>Submit new plugin</span></h2>
            	<div class="box">
                    <form id="form" action="<?= Router::pathFor('plugins.create') ?>" method="post">
                        <input type="hidden" name="csrf_name" value="<?= $csrf_name; ?>">
                        <input type="hidden" name="csrf_value" value="<?= $csrf_value; ?>">
<?php include '_form.php'; ?>
                    </form>
                    <strong>89</strong> plugins are currently in the review queue.<br>
                    Make sure your plugin has all the requirements to be valid. More informations available <a href="#" target="_blank">here</a>.
                </div>
            </div>
