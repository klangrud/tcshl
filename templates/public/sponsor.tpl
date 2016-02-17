<h1>{$sponsorName}</h1>

<table width="100%">
<tr>
  <td valign="top">
	{if $imageSize}
		<img src="engine/image_sponsor.php?id={$sponsorID}" {$imageSize} />
	{/if}  
  </td>
  <td valign="top">
    {if $sponsorURL}
    <a href="http://{$sponsorURL}" target="_blank">{$sponsorURL}</a>
    <br /><br/>    
    {/if}
    {$sponsorAbout}
  </td>
</tr>
</table>

<br />
<br />
<br />