<div id="globalSiteUserLinks">

<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----INSERT_HERE-----END PKCS7-----
">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_viewcart_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
	
	{if $logged_in}
		<a  class="globalSiteUserLinks" href="account.php">{$user}'s Account</a>
		 | 		 
		<a  class="globalSiteUserLinks" href="logout.php">Sign Out</a>
		&nbsp;
	{else}
		<a class="globalSiteUserLinks" href="siteregistration.php">Site Registration</a>
		 | 
		<a  class="globalSiteUserLinks" href="login.php">Sign In</a>
		&nbsp;
	{/if}	
</div>
