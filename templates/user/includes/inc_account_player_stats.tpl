{if $UserHasPlayerStats}
<h4>Stats</h4>

Included here are all stats you acquired since the 2007 - 2008 season.  This includes
all games where stats were recorded and you were either a regular or substitute
player.  These stats will update as stats information becomes available.  You are
the only one who can see your stats.
<br /><br />

<table border="0" width="50%">
  <tr><td colspan="6" bgcolor="#000000"><font color="#FFFFFF">Player Stats</font></td></tr>
  <tr class="globalStatSectionHead">		
	<td class="globalCenter">Season</td>
	<td class="globalCenter">GP</td>
	<td class="globalCenter">G</td>
	<td class="globalCenter">A</td>
	<td class="globalCenter">PTS</td>
	<td class="globalCenter">PIM</td>
  </tr>
	  
	  {assign var = "rowCSS" value = "globalGameEven"}
	  {section name=stats loop=$seasonID}

	    {if $rowCSS == 'globalstatsEven'}
		  {assign var = "rowCSS" value = "globalStatOdd"}
		{else}
		  {assign var = "rowCSS" value = "globalStatEven"}
	    {/if}	    
			
		<tr class="{$rowCSS}">
			<td class="globalGameStat">{$seasonName[stats]}</td>
			<td class="globalGameStat">{$games_played[stats]}</td>			
			<td class="globalGameStat">{$goals[stats]}</td>
			<td class="globalGameStat">{$assists[stats]}</td>
			<td class="globalGameStat">{$pts[stats]}</td>
			<td class="globalGameStat">{$pim[stats]}</td>
		</tr>
	  {/section}
	  <tr>
		<td class="globalGameStat">Total</td>
		<td class="globalGameStat">{$totalGP}</td>			
		<td class="globalGameStat">{$totalGoals}</td>
		<td class="globalGameStat">{$totalAssists}</td>
		<td class="globalGameStat">{$totalPoints}</td>
		<td class="globalGameStat">{$totalPIMs}</td>	  
	 </tr>
</table>  
{/if}
