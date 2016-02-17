<h1>{$page_name}</h1>

{include file="global/handlers/error_success_handler.tpl"}

<form method="post" action="gamemanager.php">
<fieldset>
<legend>Game Information</legend>
<label for="gametype">Game Type: </label>
<select name="gametype">
	<option value="pre">Pre-Season</option>
	<option value="season" selected="selected">Regular Season</option>
	<option value="post">Post Season</option>
</select>
<br /><br />
<label for="gametime">Game Time: </label>
{$monthSelect}
{$daySelect},
{$yearSelect}
at
{$hourSelect}:
{$minuteSelect} {$ampmSelect}
<br /><br />
<label for="home">Home: </label>
<select name="home">
	{section name=team loop=$teamCandidateId}
		<option value="{$teamCandidateId[team]}">{$teamCandidateName[team]}</option>
	{/section} 
</select>

<label for="guest">Guest: </label>
<select name="guest">
	{section name=team loop=$teamCandidateId}
    	<option value="{$teamCandidateId[team]}">{$teamCandidateName[team]}</option>
	{/section} 
</select>

<br /><br />
<label for="ref1">Referee 1: </label>
<select name="ref1">
	<option value="">No one yet</option>
	{section name=player loop=$playerCandidateId}
		<option value="{$playerCandidateId[player]}">{$playerCandidateName[player]}</option>
	{/section} 
</select>

<label for="ref2">Referee 2: </label>
<select name="ref2">
	<option value="">No one yet</option>
	{section name=player loop=$playerCandidateId}
    	<option value="{$playerCandidateId[player]}">{$playerCandidateName[player]}</option>
	{/section} 
</select>

<label for="ref3">Referee 3: </label>
<select name="ref3">
	<option value="">No one yet</option>
	{section name=player loop=$playerCandidateId}
    	<option value="{$playerCandidateId[player]}">{$playerCandidateName[player]}</option>
	{/section} 
</select>

<br /><br />
</fieldset>
<input name="action" type="submit" value="Add Game" />
</form>
<br /><br />


{include file="global/includes/inc_schedule.tpl"}
