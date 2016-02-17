<h1>{$seasonName} Season League Players ({if $countPlayers}{$countPlayers}{else}0{/if} Total)</h1>
{if $countPlayers > 0}
<table border="1" width="100%">
	<tr>		
		<td>Player ID</td>
		<td>Name</td>
		<td>Skill Level</td>
		<td>Position(s)</td>
		<td>Team</td>
		<td>Actions</td>
	</tr>
	{section name=player loop=$playerId}
		<tr>
			<td>{$playerId[player]}</td>
			<td>{$playerFName[player]} {$playerLName[player]}</td>
			<td>{$skillLevelName[player]}</td>
			<td>{$playerPosition[player]}</td>
			<td>{$teams[player]}</td>
			<td>{if $teams[player] == ""}<a href="assignplayerteam.php?playerid={$playerId[player]}"><img class="imglink" src="images/plus.gif" title="Assign {$playerFName[player]} {$playerLName[player]} to a team" /></a>{else}<a href="assignplayerteam.php?playerid={$playerId[player]}"><img class="imglink" src="images/plus.gif" title="Assign {$playerFName[player]} {$playerLName[player]} to another team" /></a>{/if} <a href="registrantdetails.php?registrantid={$registrationId[player]}"><img class="imglink" src="images/browse.gif" title="{$playerFName[player]} {$playerLName[player]}'s Details" /></a></td>
		</tr>
	{/section}
</table>
{else}
	There are no players whose registration has been approved. <a href="manageregistrations.php">Approve registrants to play in this league.</a>
{/if}
<br /><br />