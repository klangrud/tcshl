<h1>{$page_name}</h1>

{include file="global/handlers/error_success_handler.tpl"}

<h2>Editing goalie stat for {$playerName}</h2>

<form method="post" action="editgoaliestat.php">
<fieldset>
<legend>Goalie Stat</legend>
<input type="hidden" name="gameid" value="{$gameID}" />
<input type="hidden" name="playerid" value="{$playerID}" />
<input type="hidden" name="teamid" value="{$teamID}" />
<label for="shots">Shots on Goal: </label>
<input type="text" name="shots" value="{$shots}" />

<label for="ga">Goals Against: </label>
<input type="text" name="ga" value="{$ga}" />

<br /><br />
</fieldset>
<input name="action" type="submit" value="Edit Goalie Stat" />
</form>
<br />
<a href="javascript:history.go(-1)">Back</a>
<hr />