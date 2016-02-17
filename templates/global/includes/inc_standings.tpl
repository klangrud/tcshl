<table border="1" width="100%">
	<tr id="globalStandingsHeader">		
		<td>Team</td>
		<td class="globalStandings">GP</td>
		<td class="globalStandings">W</td>
		<td class="globalStandings">L</td>
		<td class="globalStandings">T</td>
		<td class="globalStandings">PTS</td>
		<td class="globalStandings">PCT</td>
		<td class="globalStandings">GF</td>
		<td class="globalStandings">GA</td>
	</tr>
	{section name=team loop=$teamid}
		<tr>
			<td class="globalNoWrap">{$teamname[team]}</td>
			<td class="globalStandings">{$gamesplayed[team]}</td>
			<td class="globalStandings">{$wins[team]}</td>
			<td class="globalStandings">{$losses[team]}</td>
			<td class="globalStandings">{$ties[team]}</td>
			<td class="globalStandings">{$points[team]}</td>
			<td class="globalStandings">{$winningpercentage[team]}</td>
			<td class="globalStandings">{$goalsfor[team]}</td>
			<td class="globalStandings">{$goalsagainst[team]}</td>
		</tr>
	{/section}	
	
</table>

<hr />

{if $seasonID}<h3>Other Season Standings</h3>{/if}
{section name=season loop=$seasonID}
<b>{$seasonName[season]} Season</b><br />
&nbsp;&nbsp;
<a href="standings.php?gametype=pre&season={$seasonID[season]}">Preseason</a>
 | 
<a href="standings.php?gametype=season&season={$seasonID[season]}">Regular Season</a>
 | 
<a href="standings.php?gametype=post&season={$seasonID[season]}">Postseason</a>
<br />
{/section}
