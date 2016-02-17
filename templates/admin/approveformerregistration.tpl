{if $success}
{include file="global/handlers/error_success_handler.tpl"}
<br /><br />
<a href="manageregistrations.php">Back to Manage Registrations</a>
{else}
<h1>Former League Players Not Yet Approved For {$season_name} ({if $countPlayers}{$countPlayers}{else}0{/if} Total)</h1>

{if $countPlayers > 0}
<table border="1" width="100%">
	<tr>		
		<td>Player ID</td>
		<td>Name</td>
		<td>&nbsp;</td>
	</tr>
	{section name=player loop=$playerId}
		<tr>
			<td>{$playerId[player]}</td>
			<td>{$playerFName[player]} {$playerLName[player]}</td>
			<td class="adminRegisterFormerPlayer"><a href="approveformerregistration.php?registrantid={$registrantid}&playerid={$playerId[player]}" class="adminRegisterFormerPlayerLink" title="Select {$playerFName[player]} {$playerLName[player]} for current registration.">Select {$playerFName[player]} {$playerLName[player]} for current registration.</a></td>
		</tr>
	{/section}
</table>
{else}
	There are no former players who have not been approved for this season. <a href="manageregistrations.php">Approve registrants to play this season.</a>
{/if}
{/if}
<br /><br />