<h2>Player Stats</h2>

{if $gameHasPlayerStats}
<table border="0" width="100%">
<tr>
	  
	  {assign var = "rowCSS" value = "globalGameEven"}
	  {section name=stat loop=$playerID}
	    
	    
		{if $currentTeam != $teamName[stat]}
		{assign var = "currentTeam" value = "$teamName[stat]"}
			<td>
			<table border="0" width="75%">
			  <tr><td colspan="{if $managerMode}8{else}5{/if}" bgcolor="#{$teamBGColor[stat]}"><font color="#{$teamFGColor[stat]}">{$teamName[stat]}</font></td></tr>
			  <tr class="globalStatSectionHead">		
			    {if $managerMode}
			      <td class="globalCenter">ID</td>
			    {/if}
				<td class="globalMax">Name</td>
				<td class="globalCenter">G</td>
				<td class="globalCenter">A</td>
				<td class="globalCenter">PTS</td>
				<td class="globalCenter">PIM</td>
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
			  <td class="globalCenter">{$playerID[stat]}</td>
			{/if}
			<td class="globalNoWrap">{$playerName[stat]}</td>
			<td class="globalGameStat">{$goals[stat]}</td>
			<td class="globalGameStat">{$assists[stat]}</td>
			<td class="globalGameStat">{$pts[stat]}</td>
			<td class="globalGameStat">{$pim[stat]}</td>
			{if $managerMode}
	 	      <td><a href="editplayerstat.php?gameid={$gameid}&amp;playerid={$playerID[stat]}&amp;teamid={$teamID[stat]}">Edit</a></td>
	 		  <td><a href="deleteplayerstat.php?gameid={$gameid}&amp;playerid={$playerID[stat]}&amp;teamid={$teamID[stat]}" onclick="return showAlert('you want to delete this player stat?')">Delete</a></td>
 			{/if}
		</tr>			

		{if ($currentTeam != $teamNameCheck[stat]) || $teamNameCheck[stat] == 'FINISHED'}
		    </table>
		  </td>
		{/if}
	  {/section}
</tr>
</table>

{else}
  This game currently has no player stats.
{/if}