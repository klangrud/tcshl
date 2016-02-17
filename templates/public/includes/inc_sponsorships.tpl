{if $countSponsors}
<br />
<div id="publicIndexSponsorship">
<span class="indexSubTitle">{$SPONSOR_GROUP} Sponsors</span>
<hr />
<table width="100%">	
	{assign var = "cellNum" value = "1"}
	
	{section name=sponsor loop=$sponsorID}
	{if $cellNum == '1'}
	  <tr>
	{/if}
		<td align="center">
			{if $imageSize[sponsor]}
		    	<a href="sponsor.php?sponsor={$sponsorID[sponsor]}" alt="{$sponsorName[sponsor]}" title="{$sponsorName[sponsor]}"><img class="imglink" src="engine/image_sponsor.php?id={$sponsorID[sponsor]}" {$imageSize[sponsor]} /></a>	
			{else}
				<a href="sponsor.php?sponsor={$sponsorID[sponsor]}" alt="{$sponsorName[sponsor]}" title="{$sponsorName[sponsor]}">{$sponsorName[sponsor]}</a>
			{/if}
		</td>
	{if $cellNum == '3'}
	  </tr>
	{/if}
	
    {if $cellNum == '1'}
		{assign var = "cellNum" value = "2"}
	{elseif $cellNum == '2'}
	    {assign var = "cellNum" value = "3"}
	{else}
		{assign var = "cellNum" value = "1"}
	{/if}	
	
	
	{/section}
    
    {if $cellNum == '2'}
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  </tr>	  
	{elseif $cellNum == '3'}
	  <td>&nbsp;</td>
	  </tr>	  
	{/if}
	<tr>
	  <td colspan="3">
	    <hr />
	  </td>
	</tr>	
</table>
</div>
{/if}