{if $statPlayerID || $statGoalieID}
  {if $statGoalieID}
	{include file="public/includes/inc_team_goalie_stats.tpl"} 
	  <br />
  	  <hr />
      <br />
  {/if}
 
  {if $statPlayerID}  
	{include file="public/includes/inc_team_player_stats.tpl"}
  {else}
    This team has no player stats yet.
  {/if}	
{else}
  This team has no stats yet.
{/if}