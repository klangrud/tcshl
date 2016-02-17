{if $gameID}
	{section name=game loop=$gameID}
		{if $current_gamedate != $gameDate[game]}
		{assign var = "current_gamedate" value = "$gameDate[game]"}
			<hr />
			<b>{$gameDate[game]}</b>
			<hr />			
		{/if}		
		
		{if $postponed[game]}<b>POSTPONED</b><br />{/if}
		{$gameHomeTeam[game]}<b>(H) vs</b><br />
		{$gameGuestTeam[game]}<b>(A)</b>
		<br />
		Time: {if $postponed[game]}Game Postponed{else}{$gameTime[game]}{/if}
		<br />
		Ref 1: {if $gameReferee1[game]}{$gameReferee1[game]}{else}Not Assigned{/if}</td>
		<br />
		Ref 2: {if $gameReferee2[game]}{$gameReferee2[game]}{else}Not Assigned{/if}</td>
		<br />
		Ref 3: {if $gameReferee3[game]}{$gameReferee3[game]}{else}Not Assigned{/if}</td>		
		<br /><br />
	{/section}
{else}
No games scheduled in the next ten days.
{/if}