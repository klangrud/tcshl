{include file="global/handlers/error_success_handler.tpl"}

<font class="required">* ~ Required Fields</font>

<fieldset>
	<legend>Login</legend>
	<form method="post" action="login.php">
	<label for="email">Email: <font class="asterisk_red">*</font></label><input name="email" type="text" value="{$email}" />
	<br /><br />
	<label for="password">Password: <font class="asterisk_red">*</font></label><input name="password" type="password" />
	<a href="resetpassword.php">[Forgot Password]</a>
	<br /><br />
    <input type="checkbox" name="active" /> <a href="keepactive.php">[Keep Login Active]</a>
    <br /><br />	
	<input name="action" type="submit" value="Login" />
	</form>
</fieldset>

<a href="registration.php">Not Registered?</a>