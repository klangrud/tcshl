<h2>{$page_name}</h2>

<fieldset>
<legend><b>Filter by Team</b></legend>
<b>&raquo;</b>
<a href="roster.php?season={$SEASON}" class="globalNonActiveLink">View All</a>
&nbsp;&nbsp;
<b>&raquo;</b>
<a href="#otherSeasons" class="globalNonActiveLink">Other Seasons</a>
&nbsp;&nbsp;
{section name=team loop=$teamCandidateId}
	<b>&raquo;</b>
	<a href="roster.php?season={$SEASON}&teamid={$teamCandidateId[team]}" {if $TEAM == $teamCandidateId[team]}id="globalActiveLink"{else}class="globalNonActiveLink"{/if}>{$teamCandidateName[team]}</a>
	&nbsp;&nbsp;
{/section}
</fieldset>

{if $playerID > 0}
{assign var = "rowCSS" value = "globalRosterEven"}
	{section name=roster loop=$playerID}
			{if $rowCSS == 'globalRosterEven'}
			  {assign var = "rowCSS" value = "globalRosterOdd"}
			{else}
			  {assign var = "rowCSS" value = "globalRosterEven"}
			{/if}
			{if $current_team != $teamID[roster]}
			{if $current_team > 0}
			  </table>
			  <br /><br />
			{/if}
			{assign var = "current_team" value = "$teamID[roster]"}
			<table border="0" width="50%">
			<tr class="globalRosterTableHead">
				<td colspan="2" bgcolor="#{$teamBGColor[roster]}"><font color="#{$teamFGColor[roster]}">{$teamName[roster]}</font></td>
			</tr>
			<tr class="globalRosterSectionHead">		
				<td class="globalNoWrap">Jersey #</td>
				<td width="100%">Player</td>
			</tr>			
			{/if}		
		
			<tr class="{$rowCSS}">
				<td align="center">{$jerseyNumber[roster]}</td>
				<td class="globalNoWrap">{$playerName[roster]}</td>				
			</tr>
	{/section}
</table>
{else}
	This season has no roster yet.</a>
{/if}
