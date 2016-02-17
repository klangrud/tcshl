{if $countAwards > 0}
<h1>League Awards</h1>
<table border="1" width="100%">
	{assign var = "currentSeason" value = "SEASON"}
	{section name=award loop=$awardID}	
		{if $currentSeason != $seasonName[award]}
		{if $currentSeason != "SEASON"}
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
		{/if}
		  {assign var = "currentSeason" value = $seasonName[award]}			
			<tr>
				<td colspan="2" class="publicAwardsTableHead">{$seasonName[award]} Season Awards</td>
			</tr>
			<tr>		
				<td class="publicAwardsSubTableHead">Award</td>
				<td class="publicAwardsSubTableHead">Recipient</td>
			</tr>			
		{/if}	
		<tr>
			<td class="globalCenter"><a href="award.php?award={$awardID[award]}">{$awardName[award]}</a></td>
			<td class="globalCenter">{$recipient[award]}</td>
		</tr>
	{/section}
</table>
<br /><br />
{/if}
