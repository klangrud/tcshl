{if $playerID}
	<table border="0" width="75%" valign="top">
	<tr class="globalRosterTableHead">
		<td colspan="2" bgcolor="#{$teamBGColor}"><font color="#{$teamFGColor}">Roster</font></td>
	</tr>
	<tr class="globalRosterSectionHead">		
		<td class="globalNoWrap">Jersey #</td>
		<td width="100%">Player</td>
	</tr>
	{section name=roster loop=$playerID}
			{if $rowCSS == 'globalRosterEven'}
			  {assign var = "rowCSS" value = "globalRosterOdd"}
			{else}
			  {assign var = "rowCSS" value = "globalRosterEven"}
			{/if}
			<tr class="{$rowCSS}">
				<td align="center">{$jerseyNumber[roster]}</td>
				<td class="globalNoWrap">{$playerName[roster]}</td>				
			</tr>
	{/section}
	</table>
{else}
  This team has no roster yet.
{/if}