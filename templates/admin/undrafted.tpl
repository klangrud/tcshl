<h1>{$seasonName} Season Undrafted Players ({if $countPlayers}{$countPlayers}{else}0{/if} Total)</h1>
{if $metaRefresh > 0}
	<b>Date:</b> {$currentDate}
	<br />
	Undrafted list will update every {$metaRefresh} seconds.	
	<br /><br />
{/if}
{if $countPlayers > 0}
This is a list of authorized players who have not been drafted at least one time.
<table border="1" width="100%">
	<tr>
		<td><b>Name</b></td>
		<td><b>Skill Level</b></td>
		<td><b>Position(s)</b></td>
	</tr>
	{section name=player loop=$countPlayers}
		<tr>
			<td>{$playerFName[player]} {$playerLName[player]}</td>
			<td>{$skillLevelName[player]}</td>
			<td>{$position[player]}</td>
		</tr>
	{/section}
</table>
{else}
	<br /><br />
	<h2>All authorized players have been drafted at least once.</h2>
	<br /><br />	
{/if}
<br /><br />