<h1>{$PAGE_NAME}</h1>



<h1>Records returned: ({if $count}{$count}{else}0{/if} Total)</h1>
{if $id}
<table border="1" width="100%">
	<tr>
		<td>Name</td>
		{if $address}		
		  <td>Address</td>
		{/if}
		{if $email}
		  <td>Email</td>
		{/if}
		{if $homephone || $workphone || $cellphone}
		  <td>Phone</td>
		{/if}
		{if $skilllevel}
		  <td>Skill Level</td>
		{/if}
		{if $position}
		  <td>Position</td>
		{/if}
		{if $jerseysize}
		  <td>Jersey Size</td>
		{/if}
		{if $jerseynumber1}
		  <td>Jersey Choice 1</td>
		{/if}
		{if $jerseynumber2}
		  <td>Jersey Choice 2</td>
		{/if}
		{if $jerseynumber3}
		  <td>Jersey Choice 3</td>
		{/if}
		{if $paymentplan}
		  <td>Payment Plan</td>
		{/if}
		{if $drilleague}
		  <td>League Membership</td>
		{/if}
		{if $usaHockeyMembership}
		  <td>USA Hockey Membership</td>
		{/if}	
		
	</tr>
	{section name=row loop=$id}
		<tr>
			<td><a href="registrantdetails.php?registrantid={$id[row]}" title="View {$fname[row]} {$lname[row]}'s Registration Details">{$fname[row]} {$lname[row]}</a></td>			
		{if $address}		
		  <td>{$address[row]}</td>
		{/if}
		{if $email}
		  <td>{$email[row]}</td>
		{/if}
		{if $homephone || $workphone || $cellphone}
			<td>
			Home: {$homephone[row]}<br />
			Work: {$workphone[row]}<br />
			Cell: {$cellphone[row]}
			</td>
		{/if}
		{if $skilllevel}
		  <td>{$skilllevel[row]}</td>
		{/if}
		{if $position}
		  <td>{$position[row]}</td>
		{/if}
		{if $jerseysize}
		  <td>{$jerseysize[row]}</td>
		{/if}
		{if $jerseynumber1}
		  <td>{$jerseynumber1[row]}</td>
		{/if}
		{if $jerseynumber2}
		  <td>{$jerseynumber2[row]}</td>
		{/if}
		{if $jerseynumber3}
		  <td>{$jerseynumber3[row]}</td>
		{/if}
		{if $paymentplan}
		  <td>{$paymentplan[row]}</td>
		{/if}	
		{if $drilleague}
		  <td>{if $drilleague[row] == "2"}D.R.I.L. Only{else}Both TCSHL and D.R.I.L.{/if}</td>
		{/if}
		{if $usaHockeyMembership[row]}
		  <td>{if $usaHockeyMembership[row] == "NONE"}<font class="globalRed">NOT a member</font>{else}<a href="https://www.usahockeyregistration.com/show_confirmation.action?confirmation={$usaHockeyMembership[row]}">{$usaHockeyMembership[row]}</a>{/if}</td>
		{/if}		
			
		</tr>
	{/section}
</table>
{else}
	This report returned no results.
{/if}