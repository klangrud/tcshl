<h1>{$page_name}</h1>

<h2>{$seasonName} Season Referees</h2>
{if $countRefs}
<table>
	<tr class="globalDefaultTableHead">
	  <td>Player Id</td>
	  <td>Name</td>
	  <td>Level (Pay Scale)</td>
	</tr>
	{assign var="rowCSS" value="globalDefaultTableOdd"}
	{section name=ref loop=$playerID}
		{if $rowCSS == "globalDefaultTableOdd"}
		  {assign var="rowCSS" value="globalDefaultTableEven"}
		{else}
		  {assign var="rowCSS" value="globalDefaultTableOdd"}
		{/if}
		<tr class="{$rowCSS}">
		  <td class="globalCenter">{$playerID[ref]}</td>
		  <td>{$playerName[ref]}</td>
		  <td class="globalCenter">{$level[ref]}</td>
		</tr>	
	{/section}
</table>
{else}
	This season has no designated referees yet.  Add a ref from the players list by selecting from the drop down below.
{/if}

<hr />

<h2>Add additional referee to {$seasonName} Season</h2>
{if $countCandidateRefs}
    <form method="post" action="managereferees.php">
    <select name="candidatePlayers">    
		{section name=player loop=$playerCandidateID}
	    	<option value="{$playerCandidateID[player]}">{$playerCandidateName[player]}</option>
		{/section}    
    </select>
    <br /><br />
    <label for="level">Referee Level: (Determines pay scale, 1 = $10 per game, 2 = $15 per game and 3 = $20 per game)</label>
    <select name="level">
      <option value="1">Level 1 Referee</a>
      <option value="2">Level 2 Referee</a>
      <option value="3">Level 3 Referee</a>
    </select>
    <br /><br />
    <input name="action" type="submit" value="Add Ref To Season" />
    </form>
{else}
	There are no players left that can be added as referees to this season.  If a player is
	missing from this seasons players, you will need to add that player.
{/if}

<br /><br />