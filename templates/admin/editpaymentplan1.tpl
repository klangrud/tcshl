<h1>{$PAGE_NAME}</h1>

{include file="global/handlers/error_success_handler.tpl"}

<h2>Edit payments for: {$P1_NAME}</h2>

<a href="paymentmanager.php">Back to Payment Manager</a>
<br /><br />

<form method="post" action="editpaymentplan1.php">
<input name="id" type="hidden" value="{$P1_ID}" />
<input name="p1_pay1_date_db" type="hidden" value="{$P1_PAY1_DATE_DB}" />

<fieldset>
<legend>
	Payment One ~
	{if $daysToFirstPayment < 0 && $P1_PAY1_DATE_DB == ""}
	<b class="globalRed">PAYMENT #1 IS PAST DUE</b>
	{elseif $daysToFirstPayment >= 0 && $P1_PAY1_DATE_DB == ""}
	Payment due in {$daysToFirstPayment} days
	{else}
	<b class="globalGreen">PAID</b>
	{/if}
</legend>
<input name="update1" type="checkbox" value="YES" {$P1_PAY1_PROCESS} /><label for="update1"> Check to Update</label>
<br />
<label for="paymentOneDate">Payment Received: </label>{$P1_PAY1_DATE_SELECT}
<br />
<label for="p1_checknum">Check # (or CASH): </label><input name="p1_checknum" type="text" value="{$P1_PAY1_CHECK}"/>
</fieldset>

<br />
<input name="action" type="submit" value="Edit Payments" />
</form>
<br />