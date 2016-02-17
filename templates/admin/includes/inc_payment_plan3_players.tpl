<h2>Payment Plan 3 Players - (3 Installments)</h2>
{if $p3_count > 0}

<table border="1" width="100%">
	<tr class="adminPayManagerUserTableHead">
		<td>Name</td>
		<td>Payment 1 - {if $daysToFirstPaymentAlt < 0}Due Date Past{else}Due In {$daysToFirstPaymentAlt} Days{/if}</td>
		<td>Check #</td>
		<td>Payment 2 - {if $daysToSecondPaymentAlt < 0}Due Date Past{else}Due In {$daysToSecondPaymentAlt} Days{/if}</td>
		<td>Check #</td>
		<td>Payment 3 - {if $daysToThirdPaymentAlt < 0}Due Date Past{else}Due In {$daysToThirdPaymentAlt} Days{/if}</td>
		<td>Check #</td>
		<td>&nbsp;</td>
	</tr>
	{section name=player loop=$p3_id}
		{if $rowCSS == 'adminPayManagerUserTableEven'}
		  {assign var = "rowCSS" value = "adminPayManagerUserTableOdd"}
		{else}
		  {assign var = "rowCSS" value = "adminPayManagerUserTableEven"}
		{/if}		
	
		<tr class="{$rowCSS}">
		
		{if ($daysToFirstPaymentAlt < 0 && $p3_paymentOneDate[player] == "&nbsp;")
		 || ($daysToSecondPaymentAlt < 0 && $p3_paymentTwoDate[player] == "&nbsp;")
		 || ($daysToThirdPaymentAlt < 0 && $p3_paymentThreeDate[player] == "&nbsp;")}
		 <td class="globalRed">
		{else}
		 <td class="globalGreen">
		{/if}		
			{$p3_name[player]}</td>
			<td>{if $daysToFirstPaymentAlt < 0 && $p3_paymentOneDate[player] == "&nbsp;"}PAST DUE{else}{$p3_paymentOneDate[player]}{/if}</td>
			<td>{$p3_p1_checknum[player]}{if $p3_p1_audit[player] && $p3_p1_audit[player] != "&nbsp;"} ({$p3_p1_audit[player]}){/if}</td>
			<td>{if $daysToSecondPaymentAlt < 0 && $p3_paymentTwoDate[player] == "&nbsp;"}PAST DUE{else}{$p3_paymentTwoDate[player]}{/if}</td>
			<td>{$p3_p2_checknum[player]}{if $p3_p2_audit[player] && $p3_p2_audit[player] != "&nbsp;"} ({$p3_p2_audit[player]}){/if}</td>
			<td>{if $daysToThirdPaymentAlt < 0 && $p3_paymentThreeDate[player] == "&nbsp;"}PAST DUE{else}{$p3_paymentThreeDate[player]}{/if}</td>
			<td>{$p3_p3_checknum[player]}{if $p3_p3_audit[player] && $p3_p3_audit[player] != "&nbsp;"} ({$p3_p3_audit[player]}){/if}</td>
			<td><a href="editpaymentplan3.php?id={$p3_id[player]}"><img src="images/edit.gif" class="imglink" /></a></td>							
		</tr>
	{/section}
</table>

{else}
  No players on this plan
{/if}