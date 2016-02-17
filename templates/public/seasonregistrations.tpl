<h1>{$seasonName} League Registrations ({if $countPlayers}{$countPlayers}{else}0{/if} Total)</h1>
If you are not on this list and need to be, <a href="registration.php">REGISTER HERE</a>.
<br/><br />
{if $countPlayers > 0}
<table border="1" width="100%">
	<tr>		
		<td></td>
		<td>Name</td>
	</tr>
	{section name=registrant loop=$countPlayers}
		<tr>
		    <td>{$countRegistrants[registrant]}</td>
			<td>{$registrantFName[registrant]} {$registrantLName[registrant]}</td>
		</tr>
	{/section}
</table>
{else}
	There are no league registrations yet.
{/if}
<br /><br />