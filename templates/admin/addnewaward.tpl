<h1>{$page_name}</h1>

{include file="global/handlers/error_success_handler.tpl"}

* ~ Season, Award Name, Recipient of Award and Priority are the only required fields.
<form method="post" action="addnewaward.php" enctype="multipart/form-data">
<fieldset>
<legend>Award Information</legend>
<label for="season">Season: </label>
{$seasonSelect}
<br/><br />
<label for="award">Award Name: </label><input name="award" type="text" size="50" maxlength="256" value="{$aw}" />
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
</fieldset>
<input name="action" type="submit" value="Add Award" />
</form> 