<h1>{$page_name}</h1>


{include file="global/handlers/error_success_handler.tpl"}

{if $paymentsuccess}
	<font class="globalGreen">Your League payment has been received.  Thank you!</font>
{elseif $paymentcancel}
	<font class="globalRed">Your League payment was canceled during checkout.</font>
	<br />
	You can make a payment later by visiting the <a href="makepayment.php">make payment</a> page.
{else}
	<font class="globalRed">There was a problem with processing your payment.  Please contact the League regarding this.</font>
{/if}

