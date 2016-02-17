<h1>{$page_name}</h1>

<b>{$name}</b>
<br /><br />

<hr />

<form method="post" action="editaccesslevel.php">
<fieldset>
<legend>Assign Site Access Level</legend>
<input type="hidden" name="userid" value="{$userID}" />
<input type="hidden" name="regdate" value="{$registeredDate}" />
<label for="userlevel">Level: </label>
<select name="userlevel">
	{section name=user loop=$accessLevelId}
		{if $accessLevelId[user] == $userLevel}
			<option value="{$accessLevelId[user]}" selected="selected">{$accessLevelName[user]}</option>
		{else}
			<option value="{$accessLevelId[user]}">{$accessLevelName[user]}</option>
		{/if}
	{/section} 
</select>
<br /><br />
</fieldset>
<input name="action" type="submit" value="Assign Access Level" />
</form>
<br />
<a href="usermanager.php">Cancel</a>
<hr />