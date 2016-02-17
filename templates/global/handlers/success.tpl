
{if $success}
  <font class="globalSuccess">
	  <b>Success!<br /></b>
	  <ul>
	  {section name=s loop=$success}
	  	<li>{$success[s]}</li>
	  {/section}
	  </ul>
  </font>	
{/if}