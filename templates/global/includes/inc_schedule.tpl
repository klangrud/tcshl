<h2>{$seasonName} Schedule ({if $countGames}{$countGames}{else}0{/if} Total Games)</h2>
{if $countGames > 0}

<fieldset>
<legend><b>Filter by Team</b></legend>
<b>&raquo;</b>
<a href="{if $managermode}gamemanager{else}schedule{/if}.php?season={$SEASON}" class="globalNonActiveLink">View All</a>
&nbsp;&nbsp;
<b>&raquo;</b>
<a href="#otherSeasons" class="globalNonActiveLink">Other Seasons</a>
&nbsp;&nbsp;
{section name=team loop=$teamCandidateId}
	<b>&raquo;</b>
	<a href="{if $managermode}gamemanager{else}schedule{/if}.php?season={$SEASON}&teamid={$teamCandidateId[team]}" {if $TEAM == $teamCandidateId[team]}id="globalActiveLink"{else}class="globalNonActiveLink"{/if}>{$teamCandidateName[team]}</a>
	&nbsp;&nbsp;
{/section}
</fieldset>

<span class="globalFormToggle"><a id="js_key" href="javascript:toggleObjectForm('div_key','js_key','view key','close key');">view key</a></span>
<div id="div_key" style="display: none">
<br />
<img class="imglink" src="images/speech_bubble.gif" title="Game Note" />
 - Game Note.
<br />
<img class="imglink" src="images/game_stats.gif" title="Game Stats" />
 - Game Stats.
{if $managermode} 
	<br />
	<img class="imglink" src="images/referee.gif" title="Referee" />
	 - Edit Game Referees.
	 <br />
	<img class="imglink" src="images/scoreboard.gif" title="Score" />
	 - Edit Game Score.
	 <br />
	<img class="imglink" src="images/browse.gif" title="Stats" />
	 - Edit Player Game Stats.
	 <br />	 
	<img class="imglink" src="images/ppd_red.gif" title="Postponed" />
	 - Game Has Been Postponed.
	 <br />
	<img class="imglink" src="images/ppd_green.gif" title="Postpone" />
	 - Postpone Game.
	 <br />
	<img class="imglink" src="images/reschedule.gif" title="Reschedule" />
	 - Reschedule Game. 	 	 	 	 
	
{/if}
</div>

<table border="0" width="100%" cellpadding="5">
{assign var = "rowCSS" value = "globalGameEven"}
	{section name=game loop=$gameCount}
			{if $rowCSS == 'globalGameEven'}
			  {assign var = "rowCSS" value = "globalGameOdd"}
			{else}
			  {assign var = "rowCSS" value = "globalGameEven"}
			{/if}
			{if $current_gametype != $gameType[game]}
			{assign var = "current_gametype" value = "$gameType[game]"}
			<tr id="globalSchedule{$current_gametype}TableHead">
				<td colspan="7">
				{if $gameType[game] == 'season'}
			      Regular Season
				{elseif $gameType[game] == 'pre'}
				  Pre Season
				{elseif $gameType[game] == 'post'}
				  Post Season
				{/if}
				</td>
			</tr>
			<tr class="globalScheduleSectionHead">		
				<td>Home</td>
				<td>Away</td>			
				<td>Date</td>
				<td>Time</td>
				<td>Score</td>
				<td>Referees</td>
				<td>&nbsp;</td>		
			</tr>			
			{/if}		
		
		<tr class="{if $gameToday[game]}globalGameToday{else}{$rowCSS}{/if}">
			<td>{$gameHomeTeam[game]} <b>{$gameHomeScore[game]}</b></td>
			<td>{$gameGuestTeam[game]} <b>{$gameGuestScore[game]}</b></td>
			<td class="globalNoWrap">{$gameDate[game]}</td>
			<td class="globalNoWrap">{$gameTime[game]}</td>
			<td class="globalGameScore">{if $gameGuestScore[game] > '-1' && $gameHomeScore[game] > '-1'}{$gameHomeScore[game]} - {$gameGuestScore[game]}{else}&nbsp;{/if}</td>			
			<td>
			{if $gameReferee1[game] || $gameReferee2[game] || $gameReferee2[game]}
				<ol class="globalOrderedListNoMargin">
				{if $gameReferee1[game]}<li>{$gameReferee1[game]}</li>{/if}
				{if $gameReferee2[game]}<li>{$gameReferee2[game]}</li>{/if}
				{if $gameReferee3[game]}<li>{$gameReferee3[game]}</li>{/if}			
				</ol>			
			{else}&nbsp;{/if}
			</td>			
			<td class="globalNoWrap">
			{if $announcementID[game] == 'NA'}&nbsp;{else}<a href="announcement.php?showannouncement=1&amp;id={$announcementID[game]}"><img class="imglink" src="images/speech_bubble.gif" title="Read game note" /></a>{/if}
			{if $gameHasStats[game]}<a href="gamestats.php?gameid={$gameId[game]}"><img class="imglink" src="images/game_stats.gif" title="View Game Stats" /></a>{/if}
			{if $managermode}
				  {if $gameTimeInPast[game]}
				    
				  {else}
				    {if $gameReferee1[game] || $gameReferee2[game]}
				      <a href="editgamerefs.php?gameid={$gameId[game]}"><img class="imglink" src="images/referee.gif" title="Edit Refs" /></a>
				    {else}
				      <a href="editgamerefs.php?gameid={$gameId[game]}"><img class="imglink" src="images/referee.gif" title="Add Refs" /></a>
				    {/if}
				  {/if}

				  {if $gameTimeInPast[game]}
				    {if $gameGuestScore[game] > '-1' || $gameHomeScore[game] > '-1'}
				      <a href="editgamescore.php?gameid={$gameId[game]}"><img class="imglink" src="images/scoreboard.gif" title="Edit Score" /></a>
				    {else}
				      <a href="editgamescore.php?gameid={$gameId[game]}"><img class="imglink" src="images/scoreboard.gif" title="Add Score" /></a>
				    {/if}
				  {else}
				    
				  {/if}

				  {if $gameTimeInPast[game]}
				      <a href="managegamestats.php?gameid={$gameId[game]}"><img class="imglink" src="images/browse.gif" title="Manage Stats" /></a>
				  {else}
				    
				  {/if}

				{if $gameTimeInPast[game]}
				
				  {if $gameGuestScore[game] > '-1' && $gameHomeScore[game] > '-1'}
				    
				  {else}
					  {if $postponed[game]}
					    <a href="managepostponement.php?rescheduleGame=1&amp;gameid={$gameId[game]}"><img class="imglink" src="images/ppd_red.gif" title="Game Postponed.  Click here to reschedule." /></a>
					  {else}
					    <a href="managepostponement.php?gameid={$gameId[game]}"><img class="imglink" src="images/ppd_green.gif" title="Postpone this game" /></a>
					  {/if}				    
				  {/if}	
				{else}
				  {if $postponed[game]}
				    <a href="managepostponement.php?rescheduleGame=1&amp;gameid={$gameId[game]}"><img class="imglink" src="images/ppd_red.gif" title="Game Postponed.  Click here to reschedule." /></a>
				  {else}
				    <a href="managepostponement.php?gameid={$gameId[game]}"><img class="imglink" src="images/ppd_green.gif" title="Postpone this game" /></a>
				  {/if}
				{/if}

				{if $gameTimeInPast[game]}
				  {if $gameGuestScore[game] > '-1' && $gameHomeScore[game] > '-1'}
				    
				  {else}
				    <a href="managepostponement.php?rescheduleGame=1&amp;gameid={$gameId[game]}"><img class="imglink" src="images/reschedule.gif" title="Reschedule this game" /></a>
				  {/if}
				{else}
				    <a href="managepostponement.php?rescheduleGame=1&amp;gameid={$gameId[game]}"><img class="imglink" src="images/reschedule.gif" title="Reschedule this game" /></a>
				{/if}					
			{/if}
			</td>				
		</tr>
	{/section}
</table>
{else}
	There are no games scheduled yet this season.</a>
{/if}
