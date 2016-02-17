 
<form onSubmit="return submit_login_button()" method="post" action="login.php">
	<label for="email">Email: </label><input class="globalBannerInput" name="email" type="text" size="20" />
	
	<label for="password">Password: </label><input class="globalBannerInput" name="password" type="password" size="15" />
	
	<input type="checkbox" name="active" /> 
	
	<a class="globalBannerLinks" href="keepactive.php">[Keep Active]</a>
	
	<input class="globalBannerSubmit" name="action" type="submit" value="Login" />

	<a class="globalBannerLinks" href="registration.php">[Register]</a>
	
	<a class="globalBannerLinks" href="resetpassword.php">[Forgot Password]</a>

</form>
