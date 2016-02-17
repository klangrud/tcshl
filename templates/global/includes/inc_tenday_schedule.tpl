{if $gameId}
<br />
<div id="publicIndexTenDaySchedule">
<span class="indexSubTitle">Upcoming Games</span>
<table border="0" width="100%" cellpadding="5">
{assign var = "rowCSS" value = "globalGameEven"}
	{section name=game loop=$gameId}
			{if $rowCSS == 'globalGameEven'}
			  {assign var = "rowCSS" value = "globalGameOdd"}
			{else}
			  {assign var = "rowCSS" value = "globalGameEven"}
			{/if}
			{if $current_gamedate != $gameDate[game]}
			{assign var = "current_gamedate" value = "$gameDate[game]"}
			<tr><td colspan="6"><hr /></td></tr>
			<tr class="globalTenDayScheduleTableHead">
				<td colspan="6">{$gameDateLabel[game]}</td>
			</tr>
			<tr class="globalScheduleSectionHead">		
				<td>Home</td>
				<td>Away</td>			
				<td>Time</td>
				<td>Referees</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>			
			{/if}		
		
		<tr class="{if $postponed[game]}globalGamePostponed{else}{$rowCSS}{/if}">
			<td>{$gameHomeTeam[game]}</td>
			<td>{$gameGuestTeam[game]}</td>
			<td class="globalNoWrap">{if $postponed[game]}POSTPONED{else}{$gameTime[game]}{/if}</td>
			<td>
			{if $gameReferee1[game] || $gameReferee2[game] || $gameReferee2[game]}
				<ol class="globalOrderedListNoMargin">
				{if $gameReferee1[game]}<li>{$gameReferee1[game]}</li>{/if}
				{if $gameReferee2[game]}<li>{$gameReferee2[game]}</li>{/if}
				{if $gameReferee3[game]}<li>{$gameReferee3[game]}</li>{/if}			
				</ol>			
			{else}&nbsp;{/if}
			</td>
			<td>{if $postponed[game]}<img class="imglink" src="images/ppd_red.gif" title="Game Postponed." /></a>{else}&nbsp;{/if}</td>
			<td>{if $announcementID[game] == 'NA'}&nbsp;{else}<a href="announcement.php?showannouncement=1&amp;id={$announcementID[game]}"><img class="imglink" src="images/speech_bubble.gif" title="Read game note" /></a>{/if}</td>				
		</tr>
	{/section}
</table>
</div>
{/if}

