                        <div class="inform">
                            <fieldset>
                                <legend>Enter your theme infos and submit</legend>
                                <div class="infldset txtarea">
                                    <label class="required">
                                        <strong>Theme name <span>(Required)</span></strong><br />
                                        <input class="longinput" type="text" name="name" value="<?= isset(Request::getParsedBody()['name']) ? Request::getParsedBody()['name'] : ''; ?>" size="80" maxlength="70" tabindex="1" required><br/>
                                    </label>
                                    <label class="required">
                                        <strong>Repository URL <span>(Required)</span></strong><br />
                                        <input class="longinput" type="url" name="homepage" value="<?= isset(Request::getParsedBody()['homepage']) ? Request::getParsedBody()['homepage'] : ''; ?>" size="80" maxlength="70" tabindex="2" pattern="https://github\.com/[\w\-]+/[\w\-]+" required>
                                    </label>
                                </div>
                            </fieldset>
                        </div>
                        <p class="buttons"><input type="submit" name="submit" value="Submit" tabindex="3" accesskey="s" /></p>
