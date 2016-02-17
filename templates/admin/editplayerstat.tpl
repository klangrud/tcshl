<h1>{$page_name}</h1>

{include file="global/handlers/error_success_handler.tpl"}

<h2>Editing player stat for {$playerName}</h2>

<form method="post" action="editplayerstat.php">
<fieldset>
<legend>Goalie Stat</legend>
<input type="hidden" name="gameid" value="{$gameID}" />
<input type="hidden" name="playerid" value="{$playerID}" />
<input type="hidden" name="teamid" value="{$teamID}" />
<label for="goals">Goals: </label>
<input type="text" name="goals" value="{$goals}" />

<label for="assists">Assists: </label>
<input type="text" name="assists" value="{$assists}" />

<label for="pim">PIM: </label>
<input type="text" name="pim" value="{$pim}" />

<br /><br />
</fieldset>
<input name="action" type="submit" value="Edit Player Stat" />
</form>
<br />
<a href="javascript:history.go(-1)">Back</a>
<hr />