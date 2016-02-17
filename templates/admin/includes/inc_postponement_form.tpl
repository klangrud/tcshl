<form method="post" action="managepostponement.php">

<fieldset>
<legend>Optional Postponement Email Message</legend>
<input type="hidden" name="gameid" value="{$gameid}" />
<textarea name="emailbody" rows="10" cols="40"></textarea>
<br /><br />
<input type="checkbox" name="sendcorrespondence" value="YES" />
<label for="sendcorrespondence"> - Inform those involved.  By checking this box, an email will be sent to all players and referees
involved in the postponed game informing them of the postponement.  An
announcement about the postponement will also be added to the front page. 
If you wish to add an extra message within the email and announcement,
type it above.
</fieldset>
<input name="action" type="submit" value="Postpone Game" />
</form>
<br /><br />