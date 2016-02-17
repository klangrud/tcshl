<h1>{$page_name}</h1>

{include file="global/handlers/error_success_handler.tpl"}

<a id="js_newobject" href="javascript:toggleObjectForm('div_newobject','js_newobject','New Team','cancel');">{if $div_newobject_style eq 'display: none'}New Team{else}cancel{/if}</a>
<div id="div_newobject" style="{$div_newobject_style}">
	* ~ Team Name and team colors are the only required fields.
	<form method="post" action="teammanager.php">
	<fieldset>
	<legend>Add New Team</legend>
	<label for="teamName">*Team Name: </label><input name="teamName" type="text" size="50" value="{$tn}" />
	&nbsp;&nbsp;
	<label for="teamShortName">Team Short Name: </label><input name="teamShortName" type="text" value="{$tsn}" />
	<br /><br />
	<label for="teamFGColor">Team Foreground Color: </label>{$newTeamFGColorSelect}
	<br /><br />
	<label for="teamBGColor">Team Background Color: </label>{$newTeamBGColorSelect}
	<br /><br />
	</fieldset>
	<br />
	<input name="action" type="submit" value="Add New Team" />
	</form>
</div>
<br /><br />

{if $count > 0}

{section name=team loop=$teamID}
	<div id="div_editobject_{$teamID[team]}" class="fixedFloatEditForm" style="{$div_editobject_style[team]}">
	    {if $div_editobject_style[team] neq 'display: none;'}{include file="global/handlers/error_success_handler.tpl"}{/if}
		* ~ Team Name and team colors are the only required fields.
		<form method="post" action="teammanager.php">
		<input name="teamID" type="hidden" value="{$teamID[team]}" />
		<fieldset>
		<legend>Edit Team</legend>
		<label for="teamName">*Team Name: </label><input name="teamName" type="text" size="50" value="{$teamName[team]}" />
		<br /><br />
		<label for="teamShortName">Team Short Name: </label><input name="teamShortName" type="text" value="{$teamShortName[team]}" />
		<br /><br />
		<label for="teamFGColor">Team Foreground Color: </label>{$teamFGColorSelect[team]}
		<br /><br />
		<label for="teamBGColor">Team Background Color: </label>{$teamBGColorSelect[team]}
		<br /><br />
		<input name="action" type="submit" value="Edit Team" /> <a id="js_editobject_{$teamID[team]}" href="javascript:toggleObjectForm('div_editobject_{$teamID[team]}','js_editobject_{$teamID[team]}','edit','cancel');">cancel</a>
		</fieldset>
		</form>
	</div>		
{/section}

{if $count}{$count}{else}0{/if} Total
<table border="1" width="100%">
	<tr>		
		<td>Team Name</td>
		<td>Team Short Name</td>
		<td>Team Season(s)</td>
		<td>Actions</td>
	</tr>
	
	{section name=team loop=$teamID}
		<tr>
			<td bgcolor="#{$teamBGColor[team]}"><font color="#{$teamFGColor[team]}">{$teamName[team]}</font></td>
			<td bgcolor="#{$teamBGColor[team]}"><font color="#{$teamFGColor[team]}">{$teamShortName[team]}</font></td>
			<td>{$teamSeasons[team]}</td>
			<td>
			    <a id="js_editobject_{$teamID[team]}" href="javascript:toggleObjectForm('div_editobject_{$teamID[team]}','js_editobject_{$teamID[team]}','edit','cancel');">Edit</a>
			    {if $teamCanDelete[team]}<a href="teammanager.php?teamID={$teamID[team]}&delete=1" onclick='return showAlert("that you want to delete {$teamName[team]} from the team list?")'>Delete</a>{/if}
			</td>
		</tr>
	{/section}
</table>
{else}
	There are no teams for this league.  Click on "New Team" below to add some.
{/if}
<br /><br />