<h1>{$page_name}</h1>

{include file="global/handlers/error_success_handler.tpl"}

<form method="post" action="editteamrep.php">
<fieldset>
<legend>Rep Candidates</legend>
<input type="hidden" name="teamid" value="{$teamid}" />
<label for="teamrep">Rep: </label>
<select id="teamrep" name="teamrep" onload="toggle_rep_submit()" onmouseup="toggle_rep_submit()" onchange="toggle_rep_submit()">
	<option value="none">Select Rep</option>
	{section name=player loop=$playerId}
		<option value="{$playerId[player]}" {if $playerId[player] == $currentTeamRep}SELECTED{/if}>{$playerName[player]}</option>
	{/section} 
</select>
</fieldset>
<input id="action" name="action" type="submit" disabled="disabled" value="Edit Rep" />
</form>

<hr />
<a href="teamrepmanager.php">Back to Team Rep Manager</a>
<hr />