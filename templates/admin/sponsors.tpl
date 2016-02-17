<h1>League Sponsors ({if $countSponsors}{$countSponsors}{else}0{/if} Total)</h1>
{if $countSponsors > 0}
<a href="addnewsponsor.php">Create New Sponsor</a>
<br />
<a href="addsponsortoteam.php" class="userLink">Add Sponsors to Teams</a>
<br /><br />
<table border="1" width="100%">
	<tr>		
		<td>Sponsor ID</td>
		<td>Sponsor</td>
		<td>Edit Sponsor</td>	
	</tr>
	{section name=sponsor loop=$sponsorID}
		<tr>
			<td>{$sponsorID[sponsor]}</td>
			<td><a href="sponsor.php?sponsor={$sponsorID[sponsor]}">{$sponsorName[sponsor]}</a></td>
			<td><a href="editsponsor.php?sponsor={$sponsorID[sponsor]}"><img src="images/edit.gif" class="imglink" /></a></td>
		</tr>
	{/section}
</table>
{else}
	No sponsors have been created. <a href="addnewsponsor.php">Create New Sponsor.</a>
{/if}
<br /><br />