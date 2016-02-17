<h3>{$page_name}</h3>

{if $PasswordSent}
	{include file="public/includes/inc_resetpassword_success.tpl"}
{else}
	{include file="public/includes/inc_resetpassword_form.tpl"}
{/if}