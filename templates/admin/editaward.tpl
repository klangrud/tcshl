<h1>{$page_name}</h1>
<a href="awardmanager.php">Back To Award Manager</a>
<br /><br />
{include file="global/handlers/error_success_handler.tpl"}

* ~ Season, Award Name, Recipient of Award and Priority are the only required fields.
<br />
If you want to change the image, just upload a new one here.
<form method="post" action="editaward.php" enctype="multipart/form-data">
<input type="hidden" name="award" id="award" value="{$award}" />

<table width="100%" border="1">
<tr>
		{if $imageSize}
			<td valign="middle" align="center">
			Current Image
			<br /><br />	
			<img src="engine/image_award.php?id={$award}" {$imageSize} />
			<input type="hidden" name="imageWidth" id="imageWidth" value="{$imageWidth}" />
			<input type="hidden" name="imageHeight" id="imageHeight" value="{$imageHeight}" />
		{else}
			<td valign="top" align="center">
		    Award does not have an Image.  Upload one using the Image field.
		{/if}
	</td>	
	<td valign="top">
		<label for="season">Season: </label>
		{$seasonSelect}
		<br/><br />
		<label for="awardName">Award Name: </label><input name="awardName" type="text" size="50" maxlength="256" value="{$aw}" />
		<br /><br />
		<label for="recipient">Recipient of Award: </label><input name="recipient" type="text" size="50" maxlength="256" value="{$re}" />
		<br /><br />
		<label for="file">Image (JPEG):</label>
		<input type="file" name="image" id="image" />
		<br /><br />
		<label for="about">About the Award: </label>
		<br />
		<textarea name="about" rows="10" cols="40">{$ab}</textarea>
		<br/><br />
		<label for="priority">Priority (Choose priority 1 - 5.  Awards with a 1 priority are considered more important to the League than others. e.g. Hans Trophy vs Stink Pen Award.): </label>
		<br />
		{$prioritySelect}		
	</td>
</tr>
<tr>
	<td colspan="2" align="center">
		<br />
		<input name="action" type="submit" value="Edit Award" />
		<br /><br />	
	</td>
</tr>
</table>
</form> 