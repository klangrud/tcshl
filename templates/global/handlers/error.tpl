
{if $errors}
  <font class="globalError">
	  <b>There was a problem!<br />Please correct all of the following errors and resubmit the form:</b>
	  <ul>
	  {section name=error loop=$errors}
	  	<li>{$errors[error]}</li>
	  {/section}
	  </ul>
  </font>	
{/if}
