<h1>{$page_name}</h1>

<form method="post" action="makepayment.php">
<fieldset>
<legend>Search for registration</legend>

<label for="firstname">First Name: </label><input name="firstname" type="text" value="{$firstname}" />

<label for="lastname">Last Name: </label><input name="lastname" type="text" value="{$lastname}" />

<br /><br />

	
</fieldset>
<input name="action" type="submit" value="Find Registration" />
</form>

<hr />



{if $registrationId}
<table border="1" width="100%">
	<tr class="globalSubSectionHead">		
		<td class="globalCenter">Name</td>
		<td class="globalCenter">Address</td>
		<td class="globalCenter"></td>		
	</tr>
	  {assign var = "rowCSS" value = "globalRegOdd"}	
	
	{section name=reg loop=$loopID}
	
	    {if $rowCSS == 'globalRegOdd'}
		  {assign var = "rowCSS" value = "globalRegEven"}
		{else}
		  {assign var = "rowCSS" value = "globalRegOdd"}
	    {/if}
	    
		<tr class="{$rowCSS}">
			<td class="globalReg">{$name[reg]}</td>
			<td class="globalReg">{$addressOne[reg]}<br />{if $addressTwo[reg] != '&nbsp;'}{$addressTwo[reg]}<br />{/if}{$cityStateZip[reg]}</td>
			<td class="globalReg"><a href="payment.php?registrationid={$registrationId[reg]}">Make Payment</a></td>		
		</tr>
	{/section}
</table>
{else}
<br /><br />
	No data met the search criteria.
{/if}

<br /><br />