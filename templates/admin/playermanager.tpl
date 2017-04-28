<h1>{$page_name}</h1>

{include file="global/handlers/error_success_handler.tpl"}

<a id="js_newobject" href="javascript:toggleObjectForm('div_newobject','js_newobject','New Player','cancel');">{if $div_newobject_style eq 'display: none'}New Player{else}cancel{/if}</a>
<div id="div_newobject" style="{$div_newobject_style}">
        * ~ All fields required.
	<form method="post" action="playermanager.php">
        <input name="playerRegistrationId" type="hidden" value="0" />
	<fieldset>
	<legend>Add New Player</legend>
        <br/>
	<label for="playerFName">First Name: </label><input name="playerFName" type="text" size="50" value="{$pfn}" />
        <br/><br />
	<label for="playerLName">Last Name: </label><input name="playerLName" type="text" size="50" value="{$pln}" />
        <br/><br />
        <label for="season">Season: </label>
        {$seasonSelect}
        <label for="skilllevel">Skill Level: </label>
        {$skillLevelSelect}
	</fieldset>
        <br /><br />
	<input name="action" type="submit" value="Add New Player" />
        <br /><br />
	</form>
</div>
<br /><br />

{if $count > 0}

{section name=player loop=$playerID}
	<div id="div_editobject_{$playerID[player]}" class="fixedFloatEditForm" style="{$div_editobject_style[player]}">
	    {if $div_editobject_style[player] neq 'display: none;'}{include file="global/handlers/error_success_handler.tpl"}{/if}

        * ~ All fields required.
	<form method="post" action="playermanager.php">
	<input name="playerID" type="hidden" value="{$playerID[player]}" />
	<input name="playerRegistrationId" type="hidden" value="{$playerRegistrationID[player]}" />
	<fieldset>
	<legend>Edit Player</legend>
        <br/>
        <label for="playerFName">Player First Name: </label><input name="playerFName" type="text" size="50" value="{$playerFName[player]}" />
        <br/><br />
	<label for="playerLName">Player Last Name: </label><input name="playerLName" type="text" size="50" value="{$playerLName[player]}" />
        <br/><br />
        <label for="season">Season: </label>
        {$playerSeasonSelect[player]}
        <label for="skilllevel">Skill Level: </label>
        {$playerSkillLevelSelect[player]}
        <br /><br />
	<input name="action" type="submit" value="Edit Player" /> <a id="js_editobject_{$playerID[player]}" href="javascript:toggleObjectForm('div_editobject_{$playerID[player]}','js_editobject_{$playerID[player]}','edit','cancel');">cancel</a>
	</fieldset>
        <br /><br />
	</form>
	</div>		
{/section}

{if $count}{$count}{else}0{/if} Total
<table border="1" width="100%">
	<tr>		
		<td>Player ID</td>
		<td>Name</td>
		<td>Skill Level</td>
		<td>Latest Active Season</td>
		<td>Latest Registration</td>
		<td>Actions</td>
	</tr>
	
	{section name=player loop=$playerID}
		<tr>
                        <td><a href="viewplayer.php?playerid={$playerID[player]}">{$playerID[player]}</a></td>
			<td bgcolor="#FFFFFF"><font color="#000000">{$playerFName[player]} {$playerLName[player]}</font></td>
			<td>{$playerSkillLevel[player]}</td>
			<td>{$playerSeason[player]}</td>
                        <td><a href="registrantdetails.php?registrantid={$playerRegistrationID[player]}">{$playerRegistrationID[player]}</a></td>
			<td>
			    <a id="js_editobject_{$playerID[player]}" href="javascript:toggleObjectForm('div_editobject_{$playerID[player]}','js_editobject_{$playerID[player]}','edit','cancel');">Edit</a>
			    {if $playerCanDelete[player]}<a href="playermanager.php?playerID={$playerID[player]}&delete=1" onclick='return showAlert("that you want to delete {$playerFName[player]} {$playerLName[player]} from the player list?")'>Delete</a>{/if}
			    <a href="assignplayerteam.php?playerid={$playerID[player]}&manual=1&location=playermanager">Assign Team</a>
			</td>
		</tr>
	{/section}
</table>
{else}
	There are no players for this league.  Click on "New Player" below to add some.
{/if}
<br /><br />
