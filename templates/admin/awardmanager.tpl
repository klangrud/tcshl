<h1>Award Manager</h1>
{if $countAwards > 0}
<a href="addnewaward.php">Create New Award</a>
<br /><br />
<table border="1" width="100%">
	{assign var = "currentSeason" value = "SEASON"}
	{section name=award loop=$awardID}	
		{if $currentSeason != $seasonName[award]}
		{if $currentSeason != "SEASON"}
			<tr>
				<td colspan="4">&nbsp;</td>
			</tr>
		{/if}
		  {assign var = "currentSeason" value = $seasonName[award]}			
			<tr>
				<td colspan="4" class="adminAwardsTableHead">{$seasonName[award]} Season Awards</td>
			</tr>
			<tr>		
				<td class="adminAwardsSubTableHead">Award ID</td>
				<td class="adminAwardsSubTableHead">Award</td>
				<td class="adminAwardsSubTableHead">Priority</td>
				<td class="adminAwardsSubTableHead">Edit Award</td>	
			</tr>			
		{/if}	
		<tr>
			<td class="globalCenter">{$awardID[award]}</td>
			<td><a href="award.php?award={$awardID[award]}">{$awardName[award]}</a></td>
			<td class="globalCenter">{$priority[award]}</td>
			<td class="globalCenter"><a href="editaward.php?award={$awardID[award]}"><img src="images/edit.gif" class="imglink" /></a></td>
		</tr>
	{/section}
</table>
{else}
	No awards have been created. <a href="addnewaward.php">Create New Award.</a>
{/if}
<br /><br />