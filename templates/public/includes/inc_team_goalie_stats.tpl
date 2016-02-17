<table border="0" width="100%">
<tr class="globalRosterTableHead">
	<td colspan="7" bgcolor="#{$teamBGColor}"><font color="#{$teamFGColor}">Goalie Stats</font></td>
</tr>
<tr class="globalRosterSectionHead">		
	<td class="globalNoWrap">Jersey #</td>
	<td class="globalNoWrap">Player</td>
	<td class="globalCenter">GP</td>
	<td class="globalCenter">GA</td>
	<td class="globalCenter">GAA</td>
	<td class="globalCenter">SV</td>
	<td class="globalCenter">SV%</td>
</tr>
{section name=goaliestat loop=$statGoalieID}
		{if $rowCSS == 'globalRosterEven'}
		  {assign var = "rowCSS" value = "globalRosterOdd"}
		{else}
		  {assign var = "rowCSS" value = "globalRosterEven"}
		{/if}
		<tr class="{$rowCSS}">
			<td align="center">{$statGoalieJerseyNumber[goaliestat]}</td>
			<td class="globalNoWrap">{$statGoaliePlayerName[goaliestat]}</td>
			<td class="globalCenter">{$goalieGamesplayed[goaliestat]}</td>			
			<td class="globalCenter">{$ga[goaliestat]}</td>
			<td class="globalCenter">{$gaa[goaliestat]}</td>
			<td class="globalCenter">{$saves[goaliestat]}</td>
			<td class="globalCenter">{$pct[goaliestat]}</td>							
		</tr>
{/section}
</table>