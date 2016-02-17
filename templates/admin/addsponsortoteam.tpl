<h1>{$page_name}</h1>

<h2>{$seasonName} Season Teams</h2>
{if $countTeams}
<table>
	<tr class="adminSponsorTableHead">
	  <td>Team Id</td>
	  <td>Team Name</td>
	  <td>Team Sponsors</td>
	</tr>
	{section name=team loop=$teamID}
		{if $rowCSS == 'adminSponsorTableEven'}
		  {assign var = "rowCSS" value = "adminSponsorTableOdd"}
		{else}
		  {assign var = "rowCSS" value = "adminSponsorTableEven"}
		{/if}		
		<tr class="{$rowCSS}">
		  <td>{$teamID[team]}</td>
		  <td>{$teamName[team]}</td>
		  <td>{$teamSponsors[team]}</td>		  
		</tr>	
	{/section}
</table>
{else}
	This season has no teams yet.  Add a team from the drop down below.
{/if}

<h2>Add more sponsors to teams for {$seasonName} Season</h2>
{if $countCandidateSponsors}
    <form method="post" action="addsponsortoteam.php">
    <select name="candidateTeams">    
		{section name=team loop=$teamCandidateID}
	    	<option value="{$teamCandidateID[team]}">{$teamCandidateName[team]}</option>
		{/section}    
    </select>
    <select name="candidateSponsors">    
		{section name=sponsor loop=$sponsorCandidateID}
	    	<option value="{$sponsorCandidateID[sponsor]}">{$sponsorCandidateName[sponsor]}</option>
		{/section}    
    </select>    
    <input name="action" type="submit" value="Add Sponsor To Team" />
    </form>
{else}
	There are no teams left that can be added to this season.  If a team is
	missing from this seasons teams, you will need to add that team
	<a href="addnewteam.php">here</a>.
{/if}

<br /><br />