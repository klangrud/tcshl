<h2>Goalie Stats</h2>

{if $gameHasGoalieStats}
<table border="0" width="100%">
<tr>
	  
	  {assign var = "rowCSS" value = "globalGameEven"}
	  {section name=stat loop=$goaliePlayerID}
	    
	    
		{if $goalieCurrentTeam != $goalieTeamName[stat]}
		{assign var = "goalieCurrentTeam" value = "$goalieTeamName[stat]"}
			<td>
			<table border="0" width="75%">
			  <tr><td colspan="{if $managerMode}7{else}4{/if}" bgcolor="#{$goalieTeamBGColor[stat]}"><font color="#{$goalieTeamFGColor[stat]}">{$goalieTeamName[stat]}</font></td></tr>
			  <tr class="globalStatSectionHead">		
			    {if $managerMode}
			      <td class="globalCenter">ID</td>
			    {/if}
				<td class="globalMax">Name</td>
				<td class="globalCenter">SO</td>
				<td class="globalCenter">GA</td>
				{if $managerMode}
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				{/if}
			  </tr>
		{/if}	     

	    
	    {if $rowCSS == 'globalStatEven'}
		  {assign var = "rowCSS" value = "globalStatOdd"}
		{else}
		  {assign var = "rowCSS" value = "globalStatEven"}
	    {/if}	    
			<tr class="{$rowCSS}">
				{if $managerMode}
				  <td class="globalCenter">{$goaliePlayerID[stat]}</td>
				{/if}
				<td class="globalNoWrap">{$goaliePlayerName[stat]}</td>
				<td class="globalGameStat">{$shots[stat]}</td>
				<td class="globalGameStat">{$goalsagainst[stat]}</td>	
				{if $managerMode}
	 			  <td><a href="editgoaliestat.php?gameid={$gameid}&amp;playerid={$goaliePlayerID[stat]}&amp;teamid={$goalieTeamID[stat]}">Edit</a></td>
	 			  <td><a href="deletegoaliestat.php?gameid={$gameid}&amp;playerid={$goaliePlayerID[stat]}&amp;teamid={$goalieTeamID[stat]}" onclick="return showAlert('you want to delete this goalie stat?')">Delete</a></td>
	 			{/if}
			</tr>
		{if ($goalieCurrentTeam != $goalieTeamNameCheck[stat]) || $goalieTeamNameCheck[stat] == 'FINISHED'}
		    </table>
		  </td>
		{/if}
	  {/section}
</tr>
</table>

{else}
  This game currently has no goalie stats.
{/if}