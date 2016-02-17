{include file="global/handlers/error_success_handler.tpl"}

<br />
Message is the only required field.  If you want at response, you should provide your
contact information.
<br />
<fieldset>
	<legend>Send Message</legend>
	<form method="post" action="contact.php">	
	<label for="to">To: </label>
    <select name="to">    
	  <option value="lbm">League Board Members</option>
	  <option value="lps">League Payments</option>
	  <option value="lrm">League Referee Manager</option>	  
	  <option value="lrg">League Registration</option>
	  <option value="lsm">League Stats Manager</option>
	  <option value="ltr">League Team Representatives</option>
	  <option value="tsr">TCSHL Site Registration</option>
    </select>	
	<br /><br />
	<label for="msg">Message: </label>
	<br />
	<textarea name="msg" rows="10" cols="40"></textarea>
	<br /><br />
	<label for="nme">Name: </label>
	<input name="nme" type="text" />
	<br /><br />
	<label for="eml">Email: </label>
	<input name="eml" type="text" />
	<br /><br />	
	<label for="phn">Phone: </label>
	<input name="phn" type="text" />
	<br /><br />
	{$recaptcha_html}
	<input name="action" type="submit" value="Send Message" />
	</form>
</fieldset>