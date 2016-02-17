<h1>{$page_name}</h1>

{include file="global/handlers/error_success_handler.tpl"}
* ~ Sponsor Name is only required field.
<form method="post" action="addnewsponsor.php" enctype="multipart/form-data">
<fieldset>
<legend>Sponsor Information</legend>
<label for="sponsorname">Sponsor Name: </label><input name="sponsorname" type="text" value="{$sn}" />
<br /><br />
<label for="file">Logo (GIF or JPEG):</label>
<input type="file" name="logo" id="logo" />
<br /><br />
<label for="sponsorurl">Sponsor URL: </label><input name="sponsorurl" type="text" size="50" value="{$su}" />
<br /><br />
<label for="sponsorabout">Sponsor Information / About: </label>
<br />
<textarea name="sponsorabout" rows="10" cols="40">{$sa}</textarea>
</fieldset>
<input name="action" type="submit" value="Add Sponsor" />
</form> 