<h1>{$page_name}</h1>

{if $no_teams_this_season}
	No teams exist for the {$season} season. <a href="addteamtoseason.php">Add teams to the {$season} season</a>.
{else}
	{$playerName} has requested jersey numbers in this order: <b>{$jersey1} - {$jersey2} - {$jersey3}</b>
	
	{if $countAlreadyOnTeams}
	<br />
	  {$playerName} is already on the following team{if $countAlreadyOnTeams > 1}s{/if}:
		<ul>
		{section name=ao loop=$countAlreadyOnTeams}
	    	<li>{$teamAlreadyOnName[ao]}</li>
		{/section}
		</ul> 	  
	{/if}
	
	{if $jwConfictsCount}
	<br />
		Keep this in mind when assigning this player with a jersey number.
		<ul>
		{section name=jw loop=$jwConflictNum}
	    	<li>{$jwPlayerName[jw]} on team {$jwTeamName[jw]} already has number {$jwJerseyNumber[jw]}</li>
		{/section}
		</ul> 		
	{/if}
	
	<br /><br />
	
    <form method="post" action="assignplayerteam.php">
    <input type="hidden" name="playerid" value="{$playerid}" />
    <label for="candidateTeams">Team: </label>
    <select name="candidateTeams">    
		{section name=team loop=$teamCandidateID}
	    	<option value="{$teamCandidateID[team]}">{$teamCandidateName[team]}</option>
		{/section}    
    </select>
    <br /><br />
    <label for="jerseySelect">Jersey Number: </label>
    {$jerseySelect}
    <br /><br />
    <input name="action" type="submit" value="Add Player to Roster" />
    </form>
{/if}
<br /><br />