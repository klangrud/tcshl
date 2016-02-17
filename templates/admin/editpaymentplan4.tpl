<h1>{$PAGE_NAME}</h1>

{include file="global/handlers/error_success_handler.tpl"}

<h2>Edit payments for: {$P4_NAME}</h2>

<a href="paymentmanager.php">Back to Payment Manager</a>
<br /><br />

<form method="post" action="editpaymentplan4.php">
<input name="id" type="hidden" value="{$P4_ID}" />
<input name="p4_pay1_date_db" type="hidden" value="{$P4_PAY1_DATE_DB}" />
<input name="p4_pay2_date_db" type="hidden" value="{$P4_PAY2_DATE_DB}" />
<input name="p4_pay3_date_db" type="hidden" value="{$P4_PAY3_DATE_DB}" />
<input name="p4_pay4_date_db" type="hidden" value="{$P4_PAY4_DATE_DB}" />

<fieldset>
<legend>
	Payment One ~
	{if $daysToFirstPayment < 0 && $P4_PAY1_DATE_DB == ""}
	<b class="globalRed">PAYMENT #1 IS PAST DUE</b>
	{elseif $daysToFirstPayment >= 0 && $P4_PAY1_DATE_DB == ""}
	Payment due in {$daysToFirstPayment} days
	{else}
	<b class="globalGreen">PAID</b>
	{/if}
</legend>
<input name="update1" type="checkbox" value="YES" {$P4_PAY1_PROCESS} /><label for="update1"> Check to Update</label>
<br />
<label for="paymentOneDate">Payment Received: </label>{$P4_PAY1_DATE_SELECT}
<br />
<label for="p1_checknum">Check # (or CASH): </label><input name="p1_checknum" type="text" value="{$P4_PAY1_CHECK}"/>
</fieldset>

<br /><br />

<fieldset>
<legend>
	Payment Two ~
	{if $daysToSecondPayment < 0 && $P4_PAY2_DATE_DB == ""}
	<b class="globalRed">PAYMENT #2 IS PAST DUE</b>
	{elseif $daysToSecondPayment >= 0 && $P4_PAY2_DATE_DB == ""}
	Payment due in {$daysToSecondPayment} days
	{else}
	<b class="globalGreen">PAID</b>
	{/if}
</legend>
<input name="update2" type="checkbox" value="YES" {$P4_PAY2_PROCESS} /><label for="update2"> Check to Update</label>
<br />
<label for="paymentTwoDate">Payment Received: </label>{$P4_PAY2_DATE_SELECT}
<br />
<label for="p2_checknum">Check # (or CASH): </label><input name="p2_checknum" type="text" value="{$P4_PAY2_CHECK}"/>
</fieldset>

<br /><br />

<fieldset>
<legend>
	Payment Three ~
	{if $daysToThirdPayment < 0 && $P4_PAY3_DATE_DB == ""}
	<b class="globalRed">PAYMENT #3 IS PAST DUE</b>
	{elseif $daysToThirdPayment >= 0 && $P4_PAY3_DATE_DB == ""}
	Payment due in {$daysToThirdPayment} days
	{else}
	<b class="globalGreen">PAID</b>
	{/if}
</legend>
<input name="update3" type="checkbox" value="YES" {$P4_PAY3_PROCESS} /><label for="update3"> Check to Update</label>
<br />
<label for="paymentThreeDate">Payment Received: </label>{$P4_PAY3_DATE_SELECT}
<br />
<label for="p3_checknum">Check # (or CASH): </label><input name="p3_checknum" type="text" value="{$P4_PAY3_CHECK}"/>
</fieldset>

<br /><br />

<fieldset>
<legend>
	Payment Four ~
	{if $daysToFourthPayment < 0 && $P4_PAY4_DATE_DB == ""}
	<b class="globalRed">PAYMENT #4 IS PAST DUE</b>
	{elseif $daysToFourthPayment >= 0 && $P4_PAY4_DATE_DB == ""}
	Payment due in {$daysToFourthPayment} days
	{else}
	<b class="globalGreen">PAID</b>
	{/if}
</legend>
<input name="update4" type="checkbox" value="YES" {$P4_PAY4_PROCESS} /><label for="update4"> Check to Update</label>
<br />
<label for="paymentFourDate">Payment Received: </label>{$P4_PAY4_DATE_SELECT}
<br />
<label for="p4_checknum">Check # (or CASH): </label><input name="p4_checknum" type="text" value="{$P4_PAY4_CHECK}"/>
</fieldset>

<br />
<input name="action" type="submit" value="Edit Payments" />
</form>
<br />