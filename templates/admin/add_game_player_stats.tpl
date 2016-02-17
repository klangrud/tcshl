<h1>{$page_name}</h1>
<hr />
<h3>{$gameGuestTeam} vs {$gameHomeTeam}</h3>
<h3>{$gameTime}</h3>
<hr />

{include file="global/handlers/error_success_handler.tpl"}

<form id="statsform" name="statsform" method="post" action="add_game_player_stats.php">
<input type="hidden" name="gameid" value="{$gameid}" />
<input type="hidden" name="statsnum" value="{$statsnum}" />

    
{$statForm}

<br />

<input name="action" type="submit" value="Add Game Stats" />
</form>

<hr />
