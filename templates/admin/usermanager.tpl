<h1>TCSHL.COM Site Users ({if $countUsers}{$countUsers}{else}0{/if} Total)</h1>
<hr />
{if $countUsers > 0}
<b>Key:</b>
<br />
<img class="imglink" src="images/edit.gif" title="Edit Icon" />
 - Edit (Hover mouse over icon to determine exactly what will be edited).
 <br />
<table border="0" width="100%">
	<tr id="adminRegisteredUserTableHead">		
		<td>User ID</td>
		<td>Name</td>
		<td>User Name</td>		
		<td>Registered Date</td>
		<td>AccessLevel</td>
		<td>Requested Stats For</td>
		<td>Watching Stats For</td>
	</tr>
	
	{section name=user loop=$userID}
		{if $rowCSS == 'adminRegisteredUserTableEven'}
		  {assign var = "rowCSS" value = "adminRegisteredUserTableOdd"}
		{else}
		  {assign var = "rowCSS" value = "adminRegisteredUserTableEven"}
		{/if}		
		<tr class="{$rowCSS}">
			<td>{$userID[user]}</td>
			<td>{$name[user]}</td>
			<td>{$userName[user]}</td>
			<td>{$registeredDate[user]}</td>
			<td>{if $accessLevel[user] == 1}User{elseif $accessLevel[user] == 2}Admin{elseif $accessLevel[user] == 0}Not Active{else}Unknown{/if} <a href="editaccesslevel.php?userid={$userID[user]}"><img class="imglink" src="images/edit.gif" title="Edit {$name[user]}'s Site Access Level" alt="Edit {$name[user]}'s Site Access Level" /></a></td>
			<td>{if $reqPlayerId[user] > 0}{$reqPlayerName[user]}{if $reqPlayerId[user] != $playerId[user]}<a href="editwatchstat.php?userid={$userID[user]}&amp;reqplayerid={$reqPlayerId[user]}"><img class="imglink" src="images/edit.gif" title="Edit {$name[user]}'s Watch Stat" alt="Edit {$name[user]}'s Watch Stat" />{/if}{else}Nobody{/if}</td>
			<td>{if $playerId[user] > 0}{$playerName[user]}<a href="editwatchstat.php?userid={$userID[user]}&amp;reqplayerid={$reqPlayerId[user]}"><img class="imglink" src="images/edit.gif" title="Edit {$name[user]}'s Watch Stat" alt="Edit {$name[user]}'s Watch Stat" /></a>{else}<a href="editwatchstat.php?userid={$userID[user]}"><img class="imglink" src="images/edit.gif" title="Edit {$name[user]}'s Watch Stat" alt="Edit {$name[user]}'s Watch Stat" /></a>{/if}</td>			
		</tr>
	{/section}
</table>
{else}
	There are no users signed up for site registration. Which is virtually impossible.
{/if}
<hr />