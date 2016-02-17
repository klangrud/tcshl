<div id="globalBannerLinks">

	{if $menuSelectSeasonHasTeams}
	<select id="teamid" name="teamid" onchange="submit_to_team_page(value)">
	  <option value="">Select Team</option>
	  {section name=team loop=$teamMenuSelectID}
	    <option value="{$teamMenuSelectID[team]}">{$teamMenuSelectName[team]}</option>
	  {/section}
	</select>
	{/if}

	<hr />

	<a class="globalBannerLinks" href="schedule.php">Schedule</a>
	 | 
	<a class="globalBannerLinks" href="roster.php">Roster</a>
	 | 
	<a class="globalBannerLinks" href="standings.php">Standings</a>
	 | 
	<a class="globalBannerLinks" href="registration.php">Registration</a>
	<!-- <a class="globalBannerLinks" href="d7/hockey101/registration">Registration</a> -->
	 | 
	<a class="globalBannerLinks" href="boardmembers.php">League Board</a>
	 | 	 
	<a class="globalBannerLinks" href="d7/hockey101">Hockey 101</a>
	 | 	 
	<a class="globalBannerLinks" href="d7/puckotheirish">POI</a>
	 | 	 
	<a class="globalBannerLinks" href="awards.php">Awards</a>
	 |  
	<a class="globalBannerLinks" href="http://picasaweb.google.com/tcshl.kearney" target="_blank">Photos</a>
	 |
	<a class="globalBannerLinks" href="makepayment.php">League Payment</a>   
	
</div>
