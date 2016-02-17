{if $UserHasGoalieStats}
<br /><br />
<table border="0" width="50%">
  <tr><td colspan="6" bgcolor="#000000"><font color="#FFFFFF">Goalie Stats</font></td></tr>
  <tr class="globalStatSectionHead">		
	<td class="globalCenter">Season</td>
	<td class="globalCenter">GP</td>
	<td class="globalCenter">GA</td>
	<td class="globalCenter">GAA</td>
	<td class="globalCenter">SV</td>
	<td class="globalCenter">SV%</td>
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
			<td class="globalGameStat">{$ga[stats]}</td>
			<td class="globalGameStat">{$gaa[stats]}</td>
			<td class="globalGameStat">{$saves[stats]}</td>
			<td class="globalGameStat">{$pct[stats]}</td>
		</tr>
	  {/section}
	  <tr>
		<td class="globalGameStat">Total</td>
		<td class="globalGameStat">{$totalGP}</td>			
		<td class="globalGameStat">{$totalGoalsAgainst}</td>
		<td class="globalGameStat">{$overallGAA}</td>
		<td class="globalGameStat">{$totalSaves}</td>
		<td class="globalGameStat">{$overallSavePercentage}</td>	  
	 </tr>
</table>  
{/if}
