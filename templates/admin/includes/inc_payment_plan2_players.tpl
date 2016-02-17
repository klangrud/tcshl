<h2>Payment Plan 2 Players - (2 Installments)</h2>
{if $p2_count > 0}

<table border="1" width="100%">
	<tr class="adminPayManagerUserTableHead">
		<td>Name</td>
		<td>Payment 1 - {if $daysToFirstPayment < 0}Due Date Past{else}Due In {$daysToFirstPayment} Days{/if}</td>
		<td>Check #</td>
		<td>Payment 2 - {if $daysToThirdPayment < 0}Due Date Past{else}Due In {$daysToThirdPayment} Days{/if}</td>
		<td>Check #</td>
		<td>&nbsp;</td>
	</tr>
	{section name=player loop=$p2_id}
		{if $rowCSS == 'adminPayManagerUserTableEven'}
		  {assign var = "rowCSS" value = "adminPayManagerUserTableOdd"}
		{else}
		  {assign var = "rowCSS" value = "adminPayManagerUserTableEven"}
		{/if}		
	
		<tr class="{$rowCSS}">
		{if ($daysToFirstPayment < 0 && $p2_paymentOneDate[player] == "&nbsp;")
		 || ($daysToThirdPayment < 0 && $p2_paymentTwoDate[player] == "&nbsp;")}
		 <td class="globalRed">
		{else}
		 <td class="globalGreen">
		{/if}			
			{$p2_name[player]}</td>
			<td>{if $daysToFirstPayment < 0 && $p2_paymentOneDate[player] == "&nbsp;"}PAST DUE{else}{$p2_paymentOneDate[player]}{/if}</td>
			<td>{$p2_p1_checknum[player]}{if $p2_p1_audit[player] && $p2_p1_audit[player] != "&nbsp;"} ({$p2_p1_audit[player]}){/if}</td>
			<td>{if $daysToThirdPayment < 0 && $p2_paymentSecondDate[player] == "&nbsp;"}PAST DUE{else}{$p2_paymentTwoDate[player]}{/if}</td>
			<td>{$p2_p2_checknum[player]}{if $p2_p2_audit[player] && $p2_p2_audit[player] != "&nbsp;"} ({$p2_p2_audit[player]}){/if}</td>	
			<td><a href="editpaymentplan2.php?id={$p2_id[player]}"><img src="images/edit.gif" class="imglink" /></a></td>						
		</tr>
	{/section}
</table>

{else}
  No players on this plan
{/if}