<h1>{$page_name} ({if $count}{$count}{else}0{/if} Total)</h1>
{if $count > 0}
<table border="1" width="100%">
	<tr>		
		<td>Player ID</td>
		<td>Name</td>
		<td>Skill Level</td>
		<td>Latest Registration</td>
		<td>Last Active Season</td>
		<td>Actions</td>
	</tr>
	{section name=player loop=$PlayerID}
		<tr>
			<td><a href="/viewplayer.php?playerid={$PlayerID[player]}">{$PlayerID[player]}</a></td>
			<td>{$PlayerName[player]}</td>
			<td>{$CurrentSkillLevel[player]}</td>
			<td><a href="/registrantdetails.php?registrantid={$CurrentRegistrationID[player]}">{$CurrentRegistrationID[player]}</a></td>
			<td>{$LastActiveSeason[player]}</td>
		</tr>
	{/section}
</table>
{else}
	No players.
{/if}
<br /><br />