<div class="blockform">
	<h2><span>Login</span></h2>
	<div class="box">
		<form id="login" method="post" action="<?= Router::pathFor('login'); ?>">
            <input type="hidden" name="csrf_name" value="<?= $csrf_name; ?>">
            <input type="hidden" name="csrf_value" value="<?= $csrf_value; ?>">
			<div class="inform">
				<fieldset>
					<legend>Enter your username and password below</legend>
					<div class="infldset">
						<input type="hidden" name="form_sent" value="1" />
						<label class="conl required"><strong>Username <span>(Required)</span></strong><br /><input type="text" name="req_username" size="25" maxlength="25" tabindex="1" /><br /></label>
						<label class="conl required"><strong>Password <span>(Required)</span></strong><br /><input type="password" name="req_password" size="25" tabindex="2" /><br /></label>

						<div class="rbox clearb">
							<label><input type="checkbox" name="save_pass" value="1" tabindex="3" />Log me in automatically each time I visit.<br /></label>
						</div>

						<p class="clearb">Please provide the credentials used when registering to FeatherBB forum.</p>
						<p class="actions"><span><a href="http://forums.featherbb.org/register/agree/" tabindex="5" target="_blank">Not registered yet?</a></span></p>
					</div>
				</fieldset>
			</div>
			<p class="buttons"><input type="submit" name="login" value="Login" tabindex="4" /></p>
		</form>
	</div>
</div>
