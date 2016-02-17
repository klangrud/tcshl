<table border="0" width="100%">
<tr class="globalRosterTableHead">
	<td colspan="7" bgcolor="#{$teamBGColor}"><font color="#{$teamFGColor}">Player Stats</font></td>
</tr>
<tr class="globalRosterSectionHead">		
	<td class="globalNoWrap">Jersey #</td>
	<td class="globalNoWrap">Player</td>
	<td class="globalCenter">GP</td>
	<td class="globalCenter">G</td>
	<td class="globalCenter">A</td>
	<td class="globalCenter">PTS</td>
	<td class="globalCenter">PIM</td>
</tr>
{section name=stat loop=$statPlayerID}
		{if $rowCSS == 'globalRosterEven'}
		  {assign var = "rowCSS" value = "globalRosterOdd"}
		{else}
		  {assign var = "rowCSS" value = "globalRosterEven"}
		{/if}
		<tr class="{$rowCSS}">
			<td align="center">{$statJerseyNumber[stat]}</td>
			<td class="globalNoWrap">{$statPlayerName[stat]}</td>
			<td class="globalCenter">{$gamesplayed[stat]}</td>
			<td class="globalCenter">{$goals[stat]}</td>
			<td class="globalCenter">{$assists[stat]}</td>
			<td class="globalCenter">{$points[stat]}</td>
			<td class="globalCenter">{$pim[stat]}</td>								
		</tr>
{/section}
</table>