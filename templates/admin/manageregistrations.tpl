<h1>Unapproved Registrations ({if $countUnapproved}{$countUnapproved}{else}0{/if} Total)</h1>
{if $unapprovedRegistrations}
<table border="1" width="100%">
	<tr>
		<td>Name</td>
		<td>Address</td>
		<td>Email</td>
		<td>Home Phone</td>
		<td>Work Phone</td>
		<td>Cell Phone</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	{section name=registrant loop=$naregistrationId}
		<tr>
			<td><a href="registrantdetails.php?registrantid={$naregistrationId[registrant]}" title="View {$nafname[registrant]} {$nalname[registrant]}'s Registration Details">{$nafname[registrant]} {$nalname[registrant]}</a></td>
			<td>{$naaddress[registrant]}</td>
			<td>{$naemail[registrant]}</td>
			<td>{$nahomephone[registrant]}</td>
			<td>{$naworkphone[registrant]}</td>
			<td>{$nacellphone[registrant]}</td>
			<td><a href="approveregistration.php?registrantid={$naregistrationId[registrant]}" onclick='return showAlert("that you want to approve {$nafname[registrant]} {$nalname[registrant]} as a \"NEW\" league player?")'>New Player Approval</a></td>
			<td><a href="approveformerregistration.php?registrantid={$naregistrationId[registrant]}" onclick='return showAlert("that you want to approve {$nafname[registrant]} {$nalname[registrant]} as a \"FORMER\" league player?  If yes, then on the following page please select a former league player from the list.")'>Former Player Approval</a></td>			
			<td><a href="editregistration.php?id={$naregistrationId[registrant]}">Edit</a></td>
			<td><a href="manageregistrations.php?deleteregistrationid={$naregistrationId[registrant]}" onclick='return showAlert("that you want to delete registration for {$nafname[registrant]} {$nalname[registrant]}?")'>Delete</a></td>		
		</tr>
	{/section}
</table>
{else}
	There are no registrations which need to be approved.
{/if}

<h1>Approved Registrations ({if $countApproved}{$countApproved}{else}0{/if} Total)</h1>
{if $approvedRegistrations}
<table border="1" width="100%">
	<tr>
		<td>Name</td>
		<td>Player</td>		
		<td>Address</td>
		<td>Email</td>
		<td>Home Phone</td>
		<td>Work Phone</td>
		<td>Cell Phone</td>
		<td>&nbsp;</td>
	</tr>
	{section name=registrant loop=$registrationId}
		<tr>
			<td><a href="registrantdetails.php?registrantid={$registrationId[registrant]}" title="View {$fname[registrant]} {$lname[registrant]}'s Registration Details">{$fname[registrant]} {$lname[registrant]}</a></td>
			<td>{$playerName[registrant]}</td>			
			<td>{$address[registrant]}</td>
			<td>{$email[registrant]}</td>
			<td>{$homephone[registrant]}</td>
			<td>{$workphone[registrant]}</td>
			<td>{$cellphone[registrant]}</td>
			<td><a href="editregistration.php?id={$registrationId[registrant]}">Edit</a></td>
		</tr>
	{/section}
</table>
{else}
	There are no registrations which have been approved.
{/if}