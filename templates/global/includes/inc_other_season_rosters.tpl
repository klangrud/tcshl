<hr />
{if $otherSeasonID}<h3><a name="otherSeasons">Other Season Rosters</a></h3>{/if}
{section name=season loop=$otherSeasonID}
<b>{$otherSeasonName[season]} Season</b><br />
	<b>&raquo;</b>
	<a href="roster.php?season={$otherSeasonID[season]}" class="globalNonActiveLink">View All</a>
	&nbsp;&nbsp;	
	{section name=team loop=$otherSeasonTeamsID[season]}
		<b>&raquo;</b>
		<a href="roster.php?season={$otherSeasonID[season]}&teamid={$otherSeasonTeamsID[season][team]}" class="globalNonActiveLink">{$otherSeasonTeamsName[season][team]}</a>
		&nbsp;&nbsp;		
	{/section}
	<br /><br />
{/section}