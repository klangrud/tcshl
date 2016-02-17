<h1>{$page_name}</h1>

<b>{$name}</b>
<br /><br />

<hr />

<form method="post" action="editwatchstat.php">
<fieldset>
<legend>Player to watch</legend>
<input type="hidden" name="userid" value="{$userID}" />
<input type="hidden" name="regdate" value="{$registeredDate}" />
<label for="playerid">Player: </label>
<select name="playerid">
	<option value="0">No one</option>
	{section name=player loop=$playerCandidateId}
		{if $playerCandidateId[player] == $reqPlayerID}
			<option value="{$playerCandidateId[player]}" selected="selected">{$playerCandidateName[player]}</option>
		{else}
			<option value="{$playerCandidateId[player]}">{$playerCandidateName[player]}</option>
		{/if}
	{/section} 
</select>
<br /><br />
</fieldset>
<input name="action" type="submit" value="Assign Watch Stat" />
</form>
<br />
<a href="usermanager.php">Cancel</a>
<hr />