{if $metaRefresh > 0}
	<meta http-equiv="refresh" content="{$metaRefresh}" />
	Draft results will update every {$metaRefresh} seconds.
	<br />
{/if}

{if $rounds}
	<table border="1" width="100%">
	  <tr>
	    <td><b>Round</b></td>
		{section name=team loop=$teamId}
			<td><b>{$teamName[team]}</b></td>
		{/section}
	  </tr>
	 {$draftDataRows}  
	</table>
	B - Beginner; 1 - Level 1; 2 - Level 2; 3 - Level 3; 4 - Level 4
{else}
	<br /><br />
	<h2>Draft has not started yet.  Please check back later.</h2>
	<br /><br />
{/if}