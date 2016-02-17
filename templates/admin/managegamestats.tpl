<h1>{$page_name}</h1>
{include file="global/handlers/error_success_handler.tpl"}
<hr />
<h3>{$gameGuestTeam} vs {$gameHomeTeam}</h3>
<h3>{$gameTime}</h3>
<hr />
{if $gameHasGoalieStats || $gameHasPlayerStats}
  <a href="add_game_player_stats.php?gameid={$gameid}">Add More Game Stats</a>
{else}
  <a href="add_game_player_stats.php?gameid={$gameid}">Add Game Stats</a>
{/if}
<hr />
{include file="global/includes/inc_game_goalie_stats.tpl"}
<br /><br />
<hr />
{include file="global/includes/inc_game_player_stats.tpl"}
<br /><br />
<hr />
<a href="gamemanager.php">Back to game manager</a>
<hr />