<h1>{$page_name}</h1>

{include file="global/handlers/error_success_handler.tpl"}

<a id="js_newobject" href="javascript:toggleObjectForm('div_newobject','js_newobject','New Player','cancel');">{if $div_newobject_style eq 'display: none'}New Player{else}cancel{/if}</a>
<div id="div_newobject" style="{$div_newobject_style}">
        * ~ All fields required.
	<form method="post" action="playermanager.php">
        <input name="playerRegistrationId" type="hidden" value="0" />
	<fieldset>
	<legend>Add New Player</legend>
        <br/><br />
        <label for="season">Season: </label>
        {$seasonSelect}
        <br/><br />
	<label for="playerFName">First Name: </label><input name="playerFName" type="text" size="50" value="{$pfn}" />
        <br/><br />
	<label for="playerLName">Last Name: </label><input name="playerLName" type="text" size="50" value="{$pln}" />
        <br/><br />
        <legend>Skill Level:</legend>
        <br/><br />
        <input name="playerSkillLevel" type="radio" value="1" /><label for="beginnerSkill">Beginner (Less than 1 year experience, new skating, stick, etc skills)</label>
        <br /><br />
        <input name="playerSkillLevel" type="radio" value="2" /><label for="level1Skill">Level 1 (Decent forward skating, lower backward skate & stick skills, grasp of game)</label>
        <br /><br />
        <input name="playerSkillLevel" type="radio" value="3" CHECKED /><label for="level2Skill">Level 2 (Good forward movement, decent backward, good all around medium skill)</label>
        <br /><br />
        <input name="playerSkillLevel" type="radio" value="4" /><label for="level3Skill">Level 3 (Front/back skating proficient, good skills but can't move puck end to end alone)</label>
        <br /><br />
        <input name="playerSkillLevel" type="radio" value="5" /><label for="level4Skill">Level 4 (All skating, shooting, passing skills available, extensive playing background)</label>
	</fieldset>
        <br /><br />
	<input name="action" type="submit" value="Add New Player" />
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
                <br/><br />
                <label for="season">Season: </label>
                {$seasonSelect}
                <br/><br />
		<label for="playerFName">Player First Name: </label><input name="playerFName" type="text" size="50" value="{$playerFName[player]}" />
		<br /><br />
		<label for="playerLName">Player Last Name: </label><input name="playerLName" type="text" size="50" value="{$playerLName[player]}" />
		<br /><br />
                <legend>Skill Level:</legend>
                <br/><br />
                <input name="playerSkillLevel" type="radio" value="1" {$sl1[player]} /><label for="beginnerSkill">Beginner (Less than 1 year experience, new skating, stick, etc skills)</label>
                <br /><br />
                <input name="playerSkillLevel" type="radio" value="2" {$sl2[player]} /><label for="level1Skill">Level 1 (Decent forward skating, lower backward skate & stick skills, grasp of game)</label>
                <br /><br />
                <input name="playerSkillLevel" type="radio" value="3" {$sl3[player]} /><label for="level2Skill">Level 2 (Good forward movement, decent backward, good all around medium skill)</label>
                <br /><br />
                <input name="playerSkillLevel" type="radio" value="4" {$sl4[player]} /><label for="level3Skill">Level 3 (Front/back skating proficient, good skills but can't move puck end to end alone)</label>
                <br /><br />
                <input name="playerSkillLevel" type="radio" value="5" {$sl5[player]} /><label for="level4Skill">Level 4 (All skating, shooting, passing skills available, extensive playing background)</label>
                <br /><br />
		<input name="action" type="submit" value="Edit Player" /> <a id="js_editobject_{$playerID[player]}" href="javascript:toggleObjectForm('div_editobject_{$playerID[player]}','js_editobject_{$playerID[player]}','edit','cancel');">cancel</a>
		</fieldset>
		</form>
	</div>		
{/section}

{if $count}{$count}{else}0{/if} Total
<table border="1" width="100%">
	<tr>		
		<td>Name</td>
		<td>Skill Level</td>
		<td>Latest Season</td>
		<td>Registration Id</td>
		<td>Actions</td>
	</tr>
	
	{section name=player loop=$playerID}
		<tr>
			<td bgcolor="#FFFFFF"><font color="#000000">{$playerFName[player]} {$playerLName[player]}</font></td>
			<td>{$playerSkillLevel[player]}</td>
			<td>{$playerSeason[player]}</td>
			<td>{$playerRegistrationID[player]}</td>
			<td>
			    <a id="js_editobject_{$playerID[player]}" href="javascript:toggleObjectForm('div_editobject_{$playerID[player]}','js_editobject_{$playerID[player]}','edit','cancel');">Edit</a>
			    {if $playerCanDelete[player]}<a href="playermanager.php?playerID={$playerID[player]}&delete=1" onclick='return showAlert("that you want to delete {$playerName[player]} from the player list?")'>Delete</a>{/if}
			</td>
		</tr>
	{/section}
</table>
{else}
	There are no players for this league.  Click on "New Player" below to add some.
{/if}
<br /><br />
