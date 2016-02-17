<h1 class="globalCenter">
	{$recipient}
	<br />
	{$seasonName} {$award} Winner
</h1>

{if $about}
  <h3>About the Award</h3>
  {$about}
  <br /><br/> 
{/if}
{if $imageSize}
	<img class="globalCenter" src="engine/image_award.php?id={$awardID}" {$imageSize} />
{/if}  

<br />
<br />
<br />
