{if $boardMemberCount > 0}
<br />
<div id="publicIndexBoard">
<span class="indexSubTitle">TCSHL Executive Board</span>
<hr />
<table border="1" width="100%">
	<tr>		
		<td>Name</td>
		<td>Contact Information</td>		
		<td>Duties / Responsibilities</td>
	</tr>
	
	{section name=boardmember loop=$boardMemberID}
		<tr>
			<td>
				{if $boardMemberImageSize[boardmember]}	
					<img src="engine/image_boardmember.php?id={$boardMemberID[boardmember]}" {$boardMemberImageSize[boardmember]} />
					<br />
				{/if}
				{$boardMemberName[boardmember]}
			</td>
			<td>
				{if $boardMemberEmail[boardmember]}<a href="mailto:{$boardMemberEmail[boardmember]}">Email {$boardMemberName[boardmember]}</a><br />{/if}
				{if $boardMemberCellPhone[boardmember]}Cell Phone: {$boardMemberCellPhone[boardmember]}<br />
				{elseif $boardMemberHomePhone[boardmember]}Home Phone: {$boardMemberHomePhone[boardmember]}<br />
				{elseif $boardMemberWorkPhone[boardmember]}Work Phone: {$boardMemberWorkPhone[boardmember]}<br />{/if}
			</td>
			<td>{$boardMemberDuties[boardmember]}</td>
		</tr>
	{/section}
</table>
</div>
{/if}