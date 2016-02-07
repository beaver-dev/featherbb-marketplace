            <div id="postform" class="blockform">
            	<h3><span>Submit new plugin</span></h3>
                <div class="alert-box notice">
                    Currently there are <strong>89</strong> plugins in the review queue, <strong>32</strong> of which are awaiting their initial review.
                    <a href="<?= Router::pathFor('plugins.pending'); ?>">View queue</a>
                </div>
<?php if (isset($errors)): ?>
                <div class="alert-box error">
                    <span>Error</span>
                    Your plugin could not be submitted because of the following errors :
                    <ul>
<?php foreach ($errors as $error): ?>
                        <li><?= $error; ?></li>
<?php endforeach; ?>
                    </ul>
                </div>
<?php endif; ?>
            	<div class="box">
                    <form action="<?= Router::pathFor('plugins.create') ?>" method="post">
                        <input type="hidden" name="csrf_name" value="<?= $csrf_name; ?>">
                        <input type="hidden" name="csrf_value" value="<?= $csrf_value; ?>">
<?php include '_form.php'; ?>
                    </form>
                </div>
            </div>
            <div class="submit-instructions">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </p>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </p>
            </div>
