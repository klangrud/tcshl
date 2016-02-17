<h1>Player Details for {$PlayerName}</h1>
<ul>
<li>Current Skill Level - {$CurrentSkillLevel}</li>
<li><a href="/registrantdetails.php?registrantid={$CurrentRegistrationID}">View Latest Registration</a></li>
<li>Last Active Season - {$LastActiveSeason}</li>
</ul>
<h3>Seasons Played</h3>
<ul>
{section name=season loop=$SeasonsPlayed}
	<li>{$SeasonsPlayed[season]}</li>
{/section}
</ul>
<br />