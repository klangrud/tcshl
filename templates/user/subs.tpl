<h1>{$page_name}</h1>

<form method="post" action="subs.php">
<fieldset>
<legend>Search Subs</legend>
<label for="game">Game: </label>
	<select name="game">
	    <option value="0">Any</option>
		{section name=game loop=$gameId}
	    	<option value="{$gameId[game]}" {if $selectGameID==$gameId[game]}selected="selected"{/if}>{$gameDate[game]} - {$gameGuestTeam[game]} VS {$gameHomeTeam[game]}</option>
		{/section} 	    	    	    	    
	</select>
<br /><br />

<label for="skill">Skill Level: </label>
	<select name="skill">
	    <option value="0">Any</option>  	
	    <option value="1" {if $skillLevel==1}selected="selected"{/if}>Beginner</option> 
	    <option value="2" {if $skillLevel==2}selected="selected"{/if}>Level 1</option>
	    <option value="3" {if $skillLevel==3}selected="selected"{/if}>Level 2</option>
	    <option value="4" {if $skillLevel==4}selected="selected"{/if}>Level 3</option>
	    <option value="5" {if $skillLevel==5}selected="selected"{/if}>Level 4</option>	    	    	    	    
	</select>
<br /><br />

<label for="day">Day: </label>
	<select name="day">
	    <option value="0">Any</option>  	
	    <option value="1" {if $day==1}selected="selected"{/if}>Sunday</option> 
	    <option value="2" {if $day==2}selected="selected"{/if}>Monday</option>
	    <option value="3" {if $day==3}selected="selected"{/if}>Tuesday</option>
	    <option value="4" {if $day==4}selected="selected"{/if}>Wednesday</option>
	    <option value="5" {if $day==5}selected="selected"{/if}>Thursday</option>
	    <option value="6" {if $day==6}selected="selected"{/if}>Friday</option>
	    <option value="7" {if $day==7}selected="selected"{/if}>Saturday</option>	        	    	    	    
	</select>
<br /><br />

<label for="pos">Position: </label>
	<select name="pos">
	    <option value="0">Any</option>  	
	    <option value="Goalie" {if $positions=="Goalie"}selected="selected"{/if}>Goalie</option> 
	    <option value="Defense" {if $positions=="Defense"}selected="selected"{/if}>Defense</option>
	    <option value="Forward" {if $positions=="Forward"}selected="selected"{/if}>Forward</option>	    	    	    	    
	</select>
<br /><br />
	
</fieldset>
<input name="action" type="submit" value="Search Subs" />
</form>

<hr />


{if $selectGameInfo || $skillLevelName || $dayOfWeek || $positions}
	<h3> Search Results -> </h3>
		{if $selectGameInfo}<b>Game: </b> {$selectGameInfo} <br />{/if}
		{if $skillLevelName}<b>Skill:</b> {$skillLevelName} <br />{/if}
		{if $dayOfWeek}<b>Day:</b> {$dayOfWeek} <br />{/if}
		{if $positions}<b>Position:</b> {$positions} <br />{/if}
		... <a href="subs.php">Reset Search</a>	
{else}
	<h3>All Subs</h3>
{/if}

{if $name}
<table border="1" width="100%">
	<tr class="globalSubSectionHead">		
		<td class="globalCenter">Name</td>
		<td class="globalCenter">Position</td>
		<td class="globalCenter">Email</td>
		<td class="globalCenter">Home Phone</td>
		<td class="globalCenter">Work Phone</td>
		<td class="globalCenter">Cell Phone</td>
		<td class="globalCenter">Games Subbed</td>		
	</tr>
	  {assign var = "rowCSS" value = "globalSubOdd"}	
	
	{section name=sub loop=$loopID}
	
	    {if $rowCSS == 'globalSubOdd'}
		  {assign var = "rowCSS" value = "globalSubEven"}
		{else}
		  {assign var = "rowCSS" value = "globalSubOdd"}
	    {/if}
	    
		<tr class="{$rowCSS}">
			<td class="globalSub">{$name[sub]}</td>
			<td class="globalSub">{$pos[sub]}</td>
			<td class="globalSub">{$eMail[sub]}</td>
			<td class="globalSub">{$homePhone[sub]}</td>
			<td class="globalSub">{$workPhone[sub]}</td>
			<td class="globalSub">{$cellPhone[sub]}</td>
			<td class="globalSub">{$games_subbed[sub]}</td>			
		</tr>
	{/section}
</table>
{else}
<br /><br />
	No data met the search criteria.
{/if}

<br /><br />