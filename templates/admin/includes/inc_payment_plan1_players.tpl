<h2>Payment Plan 1 Players - (1 Installment)</h2>
{if $p1_count > 0}

<table border="1" width="100%">
	<tr class="adminPayManagerUserTableHead">
		<td>Name</td>
		<td>Payment 1 - {if $daysToFirstPayment < 0}Due Date Past{else}Due In {$daysToFirstPayment} Days{/if}</td>
		<td>Check #</td>
		<td>&nbsp;</td>
	</tr>
	{section name=player loop=$p1_id}
		{if $rowCSS == 'adminPayManagerUserTableEven'}
		  {assign var = "rowCSS" value = "adminPayManagerUserTableOdd"}
		{else}
		  {assign var = "rowCSS" value = "adminPayManagerUserTableEven"}
		{/if}		
	
		<tr class="{$rowCSS}">
			{if ($daysToFirstPayment < 0 && $p1_paymentOneDate[player] == "&nbsp;")}
			 <td class="globalRed">
			{else}
			 <td class="globalGreen">
			{/if}		
			{$p1_name[player]}</td>
			<td>{if $daysToFirstPayment < 0 && $p1_paymentOneDate[player] == "&nbsp;"}PAST DUE{else}{$p1_paymentOneDate[player]}{/if}</td>
			<td>{$p1_p1_checknum[player]}{if $p1_p1_audit[player] && $p1_p1_audit[player] != "&nbsp;"} ({$p1_p1_audit[player]}){/if}</td>
			<td><a href="editpaymentplan1.php?id={$p1_id[player]}"><img src="images/edit.gif" class="imglink" /></a></td>	
		</tr>
	{/section}
</table>

{else}
  No players on this plan
{/if}