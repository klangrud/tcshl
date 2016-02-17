<!-- Season Type Links -->
<br />
<a href="team.php?teamid={$teamid}&gametype=pre">Preseason</a>
 | 
<a href="team.php?teamid={$teamid}&gametype=season">Regular Season</a>
 |
<a href="team.php?teamid={$teamid}&gametype=post">Postseason</a>
<br />

<!-- Team Banner -->
<div id="publicTeamBanner" style="color: #{$teamFGColor}; background-color: #{$teamBGColor};">
  {$page_name}
</div>

<!-- Team Record -->
<div id="publicTeamRecord" style="color: #{$teamFGColor}; background-color: #{$teamBGColor};">
  {$gametype}-SEASON RECORD: {$wins}-{$losses}-{$ties}
  {if $teamRep}
    <br />
    Team Rep: {$teamRep}
  {/if}
</div>

<!-- Team Picture -->
{if $hasTeamPicture}
	<div id="publicTeamPicture" style="border-color: #{$teamBGColor};">
	  Picture
	  <div id="publicTeamPictureCaption" style="color: #{$teamFGColor}; background-color: #{$teamBGColor};">
	    Front Row: TODO, TODO, TODO
	    Back Row: TODO, TODO, TODO    
	  </div>  
	</div>
{/if}

<table border="0" width="100%">
<tr>
<td  valign="top">

<!-- Team Roster -->
{include file="public/includes/inc_team_roster.tpl"}

</td>
<td  valign="top">

<!-- Team Stats -->
{include file="public/includes/inc_team_stats.tpl"}

</td>
</tr>
</table>

<!-- Team Sponsors -->
{include file="public/includes/inc_sponsorships.tpl"}