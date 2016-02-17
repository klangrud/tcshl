<h1>{$page_name}</h1>

<h2>{$seasonName} Season Teams</h2>
{if $countTeams}
<table>
	<tr>
	  <td>Team Id</td>
	  <td>Team Name</td>
	</tr>
	{section name=team loop=$teamID}
		<tr>
		  <td>{$teamID[team]}</td>
		  <td>{$teamName[team]}</td>
		</tr>	
	{/section}
</table>
{else}
	This season has no teams yet.  Add a team from the drop down below.
{/if}

<h2>Add additional team to {$seasonName} Season</h2>
{if $countCandidateTeams}
    <form method="post" action="addteamtoseason.php">
    <select name="candidateTeams">    
		{section name=team loop=$teamCandidateID}
	    	<option value="{$teamCandidateID[team]}">{$teamCandidateName[team]}</option>
		{/section}    
    </select>
    <input name="action" type="submit" value="Add Team To Season" />
    </form>
{else}
	There are no teams left that can be added to this season.  If a team is
	missing from this seasons teams, you will need to add that team
	<a href="addnewteam.php">here</a>.
{/if}

<br /><br />