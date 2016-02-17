<h3>{$page_name}</h3>

IMPORTANT: This is for site registration.  If you were expecting league registration, <a href="registration.php">click here</a>.

<br />
{include file="global/handlers/error_success_handler.tpl"}

<font class="required">* ~ Required Fields</font>

<fieldset>
	<legend>User Information</legend>
	<form method="post" action="siteregistration.php">
	<label for="firstname">First Name: <font class="asterisk_red">*</font></label><input name="firstname" type="text" value="{$fn}" />
	<br /><br />
	<label for="lastname">Last Name: <font class="asterisk_red">*</font></label><input name="lastname" type="text" value="{$ln}" />
	<br /><br />
	<label for="email">Email: <font class="asterisk_red">*</font></label><input name="email" type="text" value="{$em}" />
	<br /><br />
	<label for="password">Password: <font class="asterisk_red">*</font></label><input name="password" type="password" />
	<br /><br />
	<label for="password2">Confirm Password: <font class="asterisk_red">*</font></label><input name="password2" type="password" />
	<br /><br />
	{$recaptcha_html}
	<input name="action" type="submit" value="Register" />
</fieldset>
	</form>