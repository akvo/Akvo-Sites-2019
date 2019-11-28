<?php
	
	$settingsOptions = $this->getSettingsOptions();
	
	if( isset( $_POST['submit'] ) ){
			
		foreach( $settingsOptions as $option_slug => $option_title ){
			update_option( $option_slug, $_POST[ $option_slug ] );
		}
	}
	
?>
<form method="POST">
	<?php foreach( $settingsOptions as $option_slug => $option_title ):?>
	<p>
		<label><?php _e( $option_title );?></label><br>
		<input type="text" name="<?php _e( $option_slug );?>" style="width: 100%; max-width: 400px;" value="<?php _e( get_option( $option_slug ) );?>" />
	</p>
	<?php endforeach;?>
	<p style="margin-bottom:50px;"></p>
	<h4>How to get a Facebook Page Access Token? <a target="_blank" href="https://www.sociablekit.com/how-to-get-a-facebook-page-access-token/">For more information</a></h4>
	<ol>
		<li>Go to <a href="https://developers.facebook.com">developers.facebook.com</a> and login with your Facebook account.</li>
		<li>On the upper right corner, click <em>"My Apps"</em> and <em>"Add New App"</em>.</li>
		<li>On the pop up, enter your <em>"Display Name"</em> and <em>"Contact Email"</em> and click <em>"Create App ID"</em> button.</li>
		<li>Pass the security check if it pops up.</li>
		<li>Go to <a href="https://developers.facebook.com/tools/explorer/">Graph API Explorer</a>.</li>
		<li>On the right side, click the <em>"Facebook App"</em> drop-down and select the app you just created.</li>
		<li>Click the <em>"Get Token"</em> drop-down and select <em>"Get Page Access Token"</em>.</li>
		<li>On the pop up, click <em>"Continue as..."</em> button. Click <em>"OK"</em> button.</li>
		<li>Click <em>"Get Token"</em> drop-down again, under the <em>"Page Access Token"</em> section, click the Facebook page you want to use.</li>
		<li>Copy the generated page access token on the <em>"Access Token"</em> field.</li>
		<li>To extend the access token, submit the token in the <a href="https://developers.facebook.com/tools/debug/accesstoken/">form here.</a></li>
	</ol>
	<p class='submit'><input type="submit" name="submit" class="button button-primary" value="Save Settings"><p>
</form>
