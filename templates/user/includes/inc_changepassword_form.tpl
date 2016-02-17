{include file="global/handlers/error_success_handler.tpl"}

<font class="required">* ~ Required Fields</font>

<fieldset>
	<legend>User Information</legend>
	<form method="post" action="changepassword.php">
	<label for="password1">New Password: <font class="asterisk_red">*</font></label><input name="password1" type="password" />
	<br /><br />
	<label for="password2">Confirm New Password: <font class="asterisk_red">*</font></label><input name="password2" type="password" />
</fieldset>
	<input name="action" type="submit" value="Change Password" />
	</form>
	