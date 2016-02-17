<h1>{$page_name}</h1>

<hr />

{if $registrationId}
	{section name=note loop=$registrationId}
			<h2>{$fname[note]} {$lname[note]}</h2>
			<ul>
			{if $travelingWithWho[note]}
			  <li>I will be traveling with {$travelingWithWho[note]}.</li>
			{/if}
			
			{if $notes[note]}
			  <li>{$notes[note]}</li>
			{/if}
			<li><a href="registrantdetails.php?registrantid={$registrationId[note]}">View {$fname[note]}'s Registration</a>.</li>
			</ul>
		<hr />
	{/section}
{else}
	<br /><br />
	<h2>There are no registrations with additional notes.</h2>
	<br /><br />
	<hr />
{/if}