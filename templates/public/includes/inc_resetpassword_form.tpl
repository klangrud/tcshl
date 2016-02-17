{include file="global/handlers/error_success_handler.tpl"}

<font class="required">* ~ Required Fields</font>

<fieldset>
	<legend>User Information</legend>
	<form method="post" action="resetpassword.php">	
	<label for="email">Email: <font class="asterisk_red">*</font></label><input name="email" type="text" value="{$em}" />
	<br /><br />
	<input name="action" type="submit" value="Reset Password" />
	</form>
</fieldset>
	