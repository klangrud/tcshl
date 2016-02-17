<h1>{$page_name}</h1>

These are the monetary balances that each ref has obtained over the course of the season.  These are calculated by counting the number 
of games a person has reffed and taking that figure times their pay scale level.  Use the game manager to make sure the correct refs
were recorded for each game.  Also, a game must have a score for it to be used in calculating toward a refs monetary balance.
<br /><br />

{if $countRefs}
<table>
	<tr class="globalDefaultTableHead">
	  <td>Player Id</td>
	  <td>Name</td>
	  <td>Level (Pay Scale)</td>
	  <td>Games Reffed</td>
	  <td>Balance (Level * Games Reffed)</td>
	</tr>
	{assign var="rowCSS" value="globalDefaultTableOdd"}
	{section name=ref loop=$playerID}
		{if $rowCSS == "globalDefaultTableOdd"}
		  {assign var="rowCSS" value="globalDefaultTableEven"}
		{else}
		  {assign var="rowCSS" value="globalDefaultTableOdd"}
		{/if}
		<tr class="{$rowCSS}">
		  <td class="globalCenter">{$playerID[ref]}</td>
		  <td>{$playerName[ref]}</td>
		  <td class="globalCenter">{$level[ref]}</td>
		  <td class="globalCenter">{$gamesReffed[ref]}</td>
		  <td class="globalCenter">{$balance[ref]}</td>
		</tr>	
	{/section}
</table>
{else}
	No games have been played yet this season.  Referee balances are all $0.
{/if}
<br /><br />
