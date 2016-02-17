<h1>{$page_name}</h1>
<a href="sponsors.php">Back To Sponsor Manager</a>
<br /><br />
{include file="global/handlers/error_success_handler.tpl"}
* ~ Sponsor Name is only required field.
<br />
If you want to change the logo, just upload a new one here.
<form method="post" action="editsponsor.php" enctype="multipart/form-data">
<input type="hidden" name="sponsor" id="sponsor" value="{$sponsor}" />

<table width="100%" border="1">
<tr>
		{if $imageSize}
			<td valign="middle" align="center">
			Current Logo
			<br /><br />	
			<img src="engine/image_sponsor.php?id={$sponsor}" {$imageSize} />
			<input type="hidden" name="logoWidth" id="logoWidth" value="{$logoWidth}" />
			<input type="hidden" name="logoHeight" id="logoHeight" value="{$logoHeight}" />
		{else}
			<td valign="top" align="center">
		    Sponsor does not have a Logo.  Upload one using the Logo field.
		{/if}
	</td>	
	<td valign="top">
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
	</td>
</tr>
<tr>
	<td colspan="2" align="center">
		<br />
		<input name="action" type="submit" value="Edit Sponsor" />
		<br /><br />	
	</td>
</tr>
</table>
</form> 