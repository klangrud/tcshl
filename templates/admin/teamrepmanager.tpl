<h1>{$page_name}</h1>
<hr />
{if teamCount}
<table border="0" width="100%">
<tr id="globalDefaultTableHead">
<td>Team</td>
<td>Rep</td>
<td>Email</td>
<td>Home Phone</td>
<td>Work Phone</td>
<td>Cell Phone</td>
<td>&nbsp;</td>
</tr>

	{section name=team loop=$teamId}
		{if $rowCSS == 'globalDefaultTableEven'}
		  {assign var = "rowCSS" value = "globalDefaultTableOdd"}
		{else}
		  {assign var = "rowCSS" value = "globalDefaultTableEven"}
		{/if}		
		<tr class="{$rowCSS}">
			<td style="color: #{$teamFGColor[team]}; background-color: #{$teamBGColor[team]}; font-weight: bolder;">{$teamName[team]}</td>
			<td>{$playerName[team]}</td>
			<td>{$eMail[team]}</td>
			<td>{$homePhone[team]}</td>
			<td>{$workPhone[team]}</td>
			<td>{$cellPhone[team]}</td>
			<td><a href="editteamrep.php?teamid={$teamId[team]}{if $teamRep[team]}&amp;teamrep={$teamRep[team]}{/if}">Edit</a></td>						
		</tr>
	{/section}
</table>
{else}
  This season has no teams associated with it yet.
{/if}

<hr />