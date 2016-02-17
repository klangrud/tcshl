<h3>{$page_name}</h3>

{if $PasswordChanged}
	{include file="user/includes/inc_changepassword_success.tpl"}
{else}
	{include file="user/includes/inc_changepassword_form.tpl"}
{/if}