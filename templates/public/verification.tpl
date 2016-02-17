<h3>{$page_name}</h3>

{if $Verified}
	{include file="public/includes/inc_activated.tpl"}
{else}
	{include file="public/includes/inc_notactivated.tpl"}
{/if}