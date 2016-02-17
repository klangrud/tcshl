<h1>{$page_name}</h1>

{include file="global/handlers/error_success_handler.tpl"}

<a id="js_newobject" href="javascript:toggleObjectForm('div_newobject','js_newobject','New Board Member','cancel');">{if $div_newobject_style eq 'display: none'}New Board Member{else}cancel{/if}</a>
<div id="div_newobject" style="{$div_newobject_style}">
	* ~ First Name and Last Name are the only required fields.
	<form method="post" action="boardmembermanager.php" enctype="multipart/form-data">
	<fieldset>
	<legend>Add New Board Member</legend>
	<label for="boardMemberFirstName">*First Name: </label><input name="boardMemberFirstName" type="text" value="{$bmfn}" />
	&nbsp;&nbsp;
	<label for="boardMemberLastName">*Last Name: </label><input name="boardMemberLastName" type="text" value="{$bmln}" />
	<br /><br />
	<label for="boardMemberEmail">Email: </label><input name="boardMemberEmail" type="text" size="50" value="{$bme}" />
	<br /><br />
	<label for="boardMemberHomePhone">Home Phone: </label><input name="boardMemberHomePhone" type="text" size="50" value="{$bmhp}" />
	<br /><br />
	<label for="boardMemberWorkPhone">Work Phone: </label><input name="boardMemberWorkPhone" type="text" size="50" value="{$bmwp}" />
	<br /><br />
	<label for="boardMemberCellPhone">Cell Phone: </label><input name="boardMemberCellPhone" type="text" size="50" value="{$bmcp}" />
	<br /><br />
	<label for="boardMemberDuties">Member Duties / Responsibilities: </label><input name="boardMemberDuties" type="text" size="50" value="{$bmd}" />
	<br /><br />
	<label for="file">Board Member Picture (GIF or JPEG):</label>
	<input type="file" name="boardMemberImage" id="boardMemberImage" value="{$bmi}"/>
	<br /><br />
	</fieldset>
	<br />
	<input name="action" type="submit" value="Add New Board Member" />
	</form>
</div>
<br /><br/>

{if $count > 0}

{section name=boardmember loop=$boardMemberID}
	<div id="div_editobject_{$boardMemberID[boardmember]}" class="fixedFloatEditForm" style="{$div_editobject_style[boardmember]}">
		* ~ First Name and Last Name are the only required fields.
		<form method="post" action="boardmembermanager.php" enctype="multipart/form-data">
		<input name="boardMemberID" type="hidden" value="{$boardMemberID[boardmember]}" />
		<fieldset>
		<legend>Edit Board Member</legend>
		<label for="boardMemberFirstName">*First Name: </label><input name="boardMemberFirstName" type="text" value="{$boardMemberFirstName[boardmember]}" />
		&nbsp;&nbsp;
		<label for="boardMemberLastName">*Last Name: </label><input name="boardMemberLastName" type="text" value="{$boardMemberLastName[boardmember]}" />
		<br /><br />
		<label for="boardMemberEmail">Email: </label><input name="boardMemberEmail" type="text" size="50" value="{$boardMemberEmail[boardmember]}" />
		<br /><br />
		<label for="boardMemberHomePhone">Home Phone: </label><input name="boardMemberHomePhone" type="text" size="50" value="{$boardMemberHomePhone[boardmember]}" />
		<br /><br />
		<label for="boardMemberWorkPhone">Work Phone: </label><input name="boardMemberWorkPhone" type="text" size="50" value="{$boardMemberWorkPhone[boardmember]}" />
		<br /><br />
		<label for="boardMemberCellPhone">Cell Phone: </label><input name="boardMemberCellPhone" type="text" size="50" value="{$boardMemberCellPhone[boardmember]}" />
		<br /><br />
		<label for="boardMemberDuties">Member Duties / Responsibilities: </label><input name="boardMemberDuties" type="text" size="50" value="{$boardMemberDuties[boardmember]}" />
		<br /><br />
		<label for="file">Board Member Picture (GIF or JPEG):</label>
		<input type="file" name="boardMemberImage" id="boardMemberImage" value="" />
		<br /><br />
		<input name="action" type="submit" value="Edit Board Member" /> <a id="js_editobject_{$boardMemberID[boardmember]}" href="javascript:toggleObjectForm('div_editobject_{$boardMemberID[boardmember]}','js_editobject_{$boardMemberID[boardmember]}','edit','cancel');">cancel</a>
		</fieldset>
		</form>		
		<br />
		{if $boardMemberImageSize[boardmember]}
			Current Image
			<br />	
			<img src="engine/image_boardmember.php?id={$boardMemberID[boardmember]}" {$boardMemberImageSize[boardmember]} />
		{else}
		    Board Member does not have a profile pic.  Upload one using the Board Member Picture field.
		{/if}		
		<br />
	</div>		
{/section}

{if $count}{$count}{else}0{/if} Total
<table border="1" width="100%">
	<tr>		
		<td>Name</td>
		<td>EMail</td>
		<td>Home Phone</td>
		<td>Work Phone</td>
		<td>Cell Phone</td>		
		<td>Duties / Responsibilities</td>
		<td>Actions</td>
	</tr>
	
	{section name=boardmember loop=$boardMemberID}
		<tr>
			<td>{$boardMemberName[boardmember]}</td>
			<td>{$boardMemberEmail[boardmember]}</td>
			<td>{$boardMemberHomePhone[boardmember]}</td>
			<td>{$boardMemberWorkPhone[boardmember]}</td>
			<td>{$boardMemberCellPhone[boardmember]}</td>
			<td>{$boardMemberDuties[boardmember]}</td>
			<td>
			    <a id="js_editobject_{$boardMemberID[boardmember]}" href="javascript:toggleObjectForm('div_editobject_{$boardMemberID[boardmember]}','js_editobject_{$boardMemberID[boardmember]}','edit','cancel');">Edit</a>
			    <a href="boardmembermanager.php?boardMemberID={$boardMemberID[boardmember]}&delete=1" onclick='return showAlert("that you want to delete {$boardMemberName[boardmember]} from the board member list?")'>Delete</a>
			</td>
		</tr>
	{/section}
</table>
{else}
	There are no board members for this league.  Click on "New Board Member" above to add some.
{/if}
<br /><br />