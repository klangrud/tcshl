<h1>{$page_name}</h1>

{if $count > 0}

<table border="1" width="100%">
	<tr class="globalTableHead">		
		<td>Name</td>
		<td>Contact Information</td>		
		<td>Duties / Responsibilities</td>
	</tr>
	
	{section name=boardmember loop=$boardMemberID}
		<tr>
			<td class="boardMember">
				{if $boardMemberImageSize[boardmember]}	
					<img src="engine/image_boardmember.php?id={$boardMemberID[boardmember]}" {$boardMemberImageSize[boardmember]} />
					<br />
				{/if}
				{$boardMemberName[boardmember]}
			</td>
			<td>
				{if $boardMemberEmail[boardmember]}<a href="mailto:{$boardMemberEmail[boardmember]}">Email {$boardMemberName[boardmember]}</a><br />{/if}
				{if $boardMemberHomePhone[boardmember]}Home Phone: {$boardMemberHomePhone[boardmember]}<br />{/if}
				{if $boardMemberWorkPhone[boardmember]}Work Phone: {$boardMemberWorkPhone[boardmember]}<br />{/if}
				{if $boardMemberCellPhone[boardmember]}Cell Phone: {$boardMemberCellPhone[boardmember]}<br />{/if}
			</td>
			<td>{$boardMemberDuties[boardmember]}</td>
		</tr>
	{/section}
</table>
{else}
	Currently there are no board members listed.
{/if}
<br /><br />


	