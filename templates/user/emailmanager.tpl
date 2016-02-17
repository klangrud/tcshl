<h1>{$page_name}</h1>

{include file="global/handlers/error_success_handler.tpl"}

The email manager can be used to send emails to specific groups within the League and TCSHL.COM.
The reply address for the email will be your account email.  This allows the recipients to respond
to you directly.
<br /><br />

<fieldset>
	<legend>Send Email</legend>
	<form method="post" action="emailmanager.php">	
	<label for="to">To: </label>
    <select id="to" name="to" onmouseup="toggle_email_submit()" onchange="toggle_email_submit()">
      <option value="none">Choose Recipients</option>
	  <option value="mass">Everyone (Former / Current Players and Site Registered Users)</option>      
	  <option value="all">All {$season_name} Season League Players</option>
	  <option value="rep">All {$season_name} Season Team Reps</option>
	  <option value="ref">All {$season_name} Season League Referees</option>
	  <option value="site">All Site Registered Users</option>  
	  <option value="web">Webmaster</option>  
      {section name=team loop=$teamCandidateId}
	    <option value="{$teamCandidateId[team]}">{$teamCandidateName[team]}</option>
	  {/section} 
    </select>	
	<br /><br />
	<input name="sub" type="text" size="100" value="Subject"/>
	<br /><br />	
	<textarea name="msg" rows="10" cols="80">Message</textarea>
	<br /><br />
	<input name="omitName" type="checkbox" value="1" />
	<label for="omitName">Omit name from automatically being added to end of email?</label>
	<br /><br />
	<label for="from">From: </label>
	<input name="from" type="text" size="20" readonly="readonly" value="{$senderName}"/>
	<br /><br />		
	<input id="action" name="action" type="submit" disabled="disabled" value="Send Email" />
	</form>
</fieldset>
