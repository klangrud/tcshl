<h1>{$page_name}</h1>

{include file="global/handlers/error_success_handler.tpl"}

*All Fields Required.

<form method="post" action="addannouncement.php">
<fieldset>
<legend>Begin Showing Announcement</legend>
{$announcementbegindate}
</fieldset>

<fieldset>
<legend>Last Day to Show Announcement</legend>
{$announcementenddate}
</fieldset>

<fieldset>
<legend>Announcement</legend>
<label for="announcementtitle">Title: </label><input name="announcementtitle" type="text" value="{$at}" size="50" />
<br /><br />
<label for="announcementbody">Body: </label>
<br />
<textarea name="announcementbody" rows="10" cols="40">{$an}</textarea>
<br /><br />
</fieldset>
<input name="action" type="submit" value="Add Announcement" />
</form>
<br /><br />