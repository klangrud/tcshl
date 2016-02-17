
<form method="post" action="managepostponement.php">
<fieldset>
<legend>Reschedule Game</legend>
<input type="hidden" name="gameid" value="{$gameid}" />
<label for="gametime">Game Time: </label>
{$monthSelect}
{$daySelect},
{$yearSelect}
at
{$hourSelect}:
{$minuteSelect} {$ampmSelect}
<br /><br />
<label for="emailbody">Optional Email Message: </label>
<textarea name="emailbody" rows="10" cols="40"></textarea>
<br /><br />
<input type="checkbox" name="sendcorrespondence" value="YES" />
<label for="sendcorrespondence"> - Inform those involved.  By checking this box, an email will be sent to all players and referees
involved in the game informing them of its rescheduled time.  An
announcement about the reschedule will also be added to the front page. 
If you wish to add an extra message within the email and announcement,
type it above.
</fieldset>
<input name="action" type="submit" value="Reschedule Game" />
</form>
<br /><br />