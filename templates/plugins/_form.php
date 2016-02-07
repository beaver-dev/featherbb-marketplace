            			<div class="inform">
                            <div class="row">
                                <div class="five columns">
                                    <label for="name">Name</label>
                                    <input class="u-full-width" placeholder="Private Messages" id="name" name="name" type="text" value="<?= isset(Request::getParsedBody()['name']) ? Request::getParsedBody()['name'] : ''; ?>" required>
                                </div>
                                <div class="seven columns">
                                    <label for="homepage">Repository URL</label>
                                    <input class="u-full-width" placeholder="https://github.com/username/plugin-name" id="homepage" name="homepage" value="<?= isset(Request::getParsedBody()['homepage']) ? Request::getParsedBody()['homepage'] : ''; ?>" type="url" pattern="https://github\.com/[\w\-]+/[\w\-]+" required>
                                </div>
                            </div>
            			</div>
            			<input type="submit" name="submit" value="Submit" tabindex="3" accesskey="s" class="u-full-width button-primary" />
