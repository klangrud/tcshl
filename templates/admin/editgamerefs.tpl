<h1>{$page_name}</h1>

<b>Game ID:</b> {$gameID}
<br />
<b>Game Time:</b> {$gameTime}
<br />
<b>Game Guest Team:</b> {$gameGuestTeam}
<br />
<b>Game Home Team:</b> {$gameHomeTeam}
<br /><br />

{include file="global/handlers/error_success_handler.tpl"}

<b>Refs:</b>
{if $refOnePlayerId || $refTwoPlayerId || $refThreePlayerId}
  <br />
  <b>Referee 1: </b>   
  {if $refOnePlayerId}
    {$refOnePlayerName}
  {else}
    No One  
  {/if}
  
  <br />
  <b>Referee 2: </b>   
  {if $refTwoPlayerId}
    {$refTwoPlayerName}
  {else}
    No One     
  {/if}
  
  
  <br />
  <b>Referee 3: </b>   
  {if $refThreePlayerId}
    {$refThreePlayerName}
  {else}
    No One     
  {/if}  
{else}
  <br />
  No refs assigned to this game.
{/if}

<hr />

<form method="post" action="editgamerefs.php">
<fieldset>
<legend>Referee Candidates (Includes Referees who are not on one of the teams playing.)</legend>
<input type="hidden" name="gameid" value="{$gameID}" />
<label for="ref1">Referee 1: </label>
<select name="ref1">
	<option value=""></option>
	<option value="delete">No one</option>
	{section name=player loop=$playerCandidateId}
		<option value="{$playerCandidateId[player]}">{$playerCandidateName[player]}</option>
	{/section} 
</select>

<label for="ref2">Referee 2: </label>
<select name="ref2">
	<option value=""></option>
	<option value="delete">No one</option>
	{section name=player loop=$playerCandidateId}
    	<option value="{$playerCandidateId[player]}">{$playerCandidateName[player]}</option>
	{/section} 
</select>

<label for="ref3">Referee 3: </label>
<select name="ref3">
	<option value=""></option>
	<option value="delete">No one</option>
	{section name=player loop=$playerCandidateId}
    	<option value="{$playerCandidateId[player]}">{$playerCandidateName[player]}</option>
	{/section} 
</select>

<br /><br />
</fieldset>
<input name="action" type="submit" value="Edit Refs" />
</form>
<br />
<a href="gamemanager.php">Back to Game Manager</a>
<hr />