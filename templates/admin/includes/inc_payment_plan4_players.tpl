<h2>Payment Plan 4 Players - (4 Installments)</h2>
{if $p4_count > 0}

<table border="1" width="100%">
	<tr class="adminPayManagerUserTableHead">
		<td>Name</td>
		<td>Payment 1 - {if $daysToFirstPayment < 0}Due Date Past{else}Due In {$daysToFirstPayment} Days{/if}</td>
		<td>Check #</td>
		<td>Payment 2 - {if $daysToSecondPayment < 0}Due Date Past{else}Due In {$daysToSecondPayment} Days{/if}</td>
		<td>Check #</td>
		<td>Payment 3 - {if $daysToThirdPayment < 0}Due Date Past{else}Due In {$daysToThirdPayment} Days{/if}</td>
		<td>Check #</td>
		<td>Payment 4 - {if $daysToFourthPayment < 0}Due Date Past{else}Due In {$daysToFourthPayment} Days{/if}</td>
		<td>Check #</td>
		<td>&nbsp;</td>
	</tr>
	{section name=player loop=$p4_id}
		{if $rowCSS == 'adminPayManagerUserTableEven'}
		  {assign var = "rowCSS" value = "adminPayManagerUserTableOdd"}
		{else}
		  {assign var = "rowCSS" value = "adminPayManagerUserTableEven"}
		{/if}		
	
		<tr class="{$rowCSS}">
		
		{if ($daysToFirstPayment < 0 && $p4_paymentOneDate[player] == "&nbsp;")
		 || ($daysToSecondPayment < 0 && $p4_paymentTwoDate[player] == "&nbsp;")
		 || ($daysToThirdPayment < 0 && $p4_paymentThreeDate[player] == "&nbsp;")
		 || ($daysToFourthPayment < 0 && $p4_paymentFourDate[player] == "&nbsp;")}
		 <td class="globalRed">
		{else}
		 <td class="globalGreen">
		{/if}		
			{$p4_name[player]}</td>
			<td>{if $daysToFirstPayment < 0 && $p4_paymentOneDate[player] == "&nbsp;"}PAST DUE{else}{$p4_paymentOneDate[player]}{/if}</td>
			<td>{$p4_p1_checknum[player]}{if $p4_p1_audit[player] && $p4_p1_audit[player] != "&nbsp;"} ({$p4_p1_audit[player]}){/if}</td>
			<td>{if $daysToSecondPayment < 0 && $p4_paymentTwoDate[player] == "&nbsp;"}PAST DUE{else}{$p4_paymentTwoDate[player]}{/if}</td>
			<td>{$p4_p2_checknum[player]}{if $p4_p2_audit[player] && $p4_p2_audit[player] != "&nbsp;"} ({$p4_p2_audit[player]}){/if}</td>
			<td>{if $daysToThirdPayment < 0 && $p4_paymentThreeDate[player] == "&nbsp;"}PAST DUE{else}{$p4_paymentThreeDate[player]}{/if}</td>
			<td>{$p4_p3_checknum[player]}{if $p4_p3_audit[player] && $p4_p3_audit[player] != "&nbsp;"} ({$p4_p3_audit[player]}){/if}</td>
			<td>{if $daysToFourthPayment < 0 && $p4_paymentFourDate[player] == "&nbsp;"}PAST DUE{else}{$p4_paymentFourDate[player]}{/if}</td>
			<td>{$p4_p4_checknum[player]}{if $p4_p4_audit[player] && $p4_p4_audit[player] != "&nbsp;"} ({$p4_p4_audit[player]}){/if}</td>
			<td><a href="editpaymentplan4.php?id={$p4_id[player]}"><img src="images/edit.gif" class="imglink" /></a></td>							
		</tr>
	{/section}
</table>

{else}
  No players on this plan
{/if}