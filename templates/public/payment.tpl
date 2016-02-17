<h1>{$page_name}</h1>


{include file="global/handlers/error_success_handler.tpl"}

{$name}

<br />

Registration ID: {$regid}

{if $paymentOptionOne}
  {include file="public/includes/inc_payment_option_one.tpl"}
{/if}

{if $paymentOptionTwo}
  {include file="public/includes/inc_payment_option_two.tpl"}
{/if}

{if $paymentOptionThree}
  {include file="public/includes/inc_payment_option_three.tpl"}
{/if}
 
{if $paymentOptionFour}
  {include file="public/includes/inc_payment_option_four.tpl"}
{/if}

{if $paymentOptionSpecialOne}
  {include file="public/includes/inc_payment_option_special_one.tpl"}
{/if}

{if $paymentOptionSpecialTwo}
  {include file="public/includes/inc_payment_option_special_two.tpl"}
{/if}

{if $paymentOptionSpecialThree}
  {include file="public/includes/inc_payment_option_special_three.tpl"}
{/if}
 
{if $paymentOptionSpecialFour}
  {include file="public/includes/inc_payment_option_special_four.tpl"}
{/if}

{if $paymentOptionDril}
  {include file="public/includes/inc_payment_option_dril.tpl"}
{/if}


<br /><br />