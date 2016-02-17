<h1>{$page_name}</h1>

{if $OPEN_REGISTRATION == 1}

{include file="global/handlers/error_success_handler.tpl"}

{include file="public/includes/inc_registration_steps.tpl"}

{include file="public/includes/inc_registration_form.tpl"}

{else}
Registration is currently not open.
<br /><br />
{/if}

<br /><br />