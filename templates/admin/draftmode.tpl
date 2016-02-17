<a href="undrafted.php">View Undrafted Player List</a>
<br /><br />
{include file="global/handlers/error_success_handler.tpl"}

<form method="post" action="draftmode.php">
<fieldset>
<legend>Draft Form</legend>
<input type="hidden" name="currentRound" value="{$currentRound}" />
<label for="team">Team: </label>
<select name="team">
	{section name=team loop=$teamCandidateId}
		<option value="{$teamCandidateId[team]}">{$teamCandidateName[team]}</option>
	{/section} 
</select>

<br /><br />

<label for="player">Player: </label>
<select name="player">
	{section name=player loop=$playerCandidateId}
		<option value="{$playerCandidateId[player]}">{$playerCandidateName[player]}</option>
	{/section} 
</select>

<br /><br />
</fieldset>
<input name="action" type="submit" value="Draft Player" />
</form>
<br /><br />
