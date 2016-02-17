<h1>{$page_name}</h1>

<b>ID:</b> {$gameID}
<br />
<b>Time:</b> {$gameTime}
<br />
<b>Home Team:</b> {$gameHomeTeam} {if $gameHomeScore >= 0}- {$gameHomeScore}{/if}
<br />
<b>Away Team:</b> {$gameGuestTeam} {if $gameGuestScore >= 0}- {$gameGuestScore}{/if}
<br /><br />

{include file="global/handlers/error_success_handler.tpl"}

<hr />

<form method="post" action="editgamescore.php">
<fieldset>
<legend>Score</legend>
<input type="hidden" name="gameid" value="{$gameID}" />

<label for="gameHomeScore">Home Score: </label>
{$gameHomeScoreSelect}
&nbsp;
&nbsp;
<label for="gameGuestScore">Away Score: </label>
{$gameGuestScoreSelect}

<br /><br />
</fieldset>
<input name="action" type="submit" value="Edit Game Score" />
</form>
<br />
<a href="gamemanager.php">Back to Game Manager</a>
<hr />