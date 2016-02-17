{if $type != 'EDIT'}<h2>League Season Registration Form</h2>{/if}

<font class="required">* ~ Required Fields</font>
{if $type == 'EDIT'}
	<form method="post" action="editregistration.php">
	<input name="id" type="hidden" value={$id} />	
{else}
	<form method="post" name="registrationform" action="registration.php">
{/if}
<br /><br />

<fieldset>

	<legend>USA Hockey Membership</legend>
	
	<ul>
	    <li>The confirmation number can be found on the confirmation email you received after registering for USA hockey membership.  It is a combination of a random number and letters from your name.</li>
	</ul>

	<label for="usaHockeyMembership">Confirmation Number: </label><input name="usaHockeyMembership" type="text" value="{$uhm}" />

	<br /><br />

</fieldset>

<br /><br />

<fieldset>

	<legend>Personal Information</legend>

	<label for="firstname">First Name: <font class="asterisk_red">*</font></label><input name="firstname" type="text" value="{$fn}" />
	<label for="lastname">Last Name: <font class="asterisk_red">*</font></label><input name="lastname" type="text" value="{$ln}" />
	<br /><br />
	<label for="addressOne">Address 1: <font class="asterisk_red">*</font></label><input name="addressOne" type="text" value="{$a1}" />
	<br /><br />	
	<label for="addressTwo">Address 2: </label><input name="addressTwo" type="text" value="{$a2}" />
	<br /><br />
	<label for="city">City: <font class="asterisk_red">*</font></label><input name="city" type="text" value="{$cy}" />
	<label for="state">State: <font class="asterisk_red">*</font></label><input name="state" type="text" value="{$state}" />
	<label for="postalCode">Zip: <font class="asterisk_red">*</font></label><input name="postalCode" type="text" value="{$pc}" />
	<br /><br />			
	<label for="email">Email: </label><input name="email" type="text" value="{$em}" />
	<br /><br />
	<label for="homePhone">Home Phone: </label><input name="homePhone" type="text" value="{$hp}" />
	<br /><br />
	<label for="workPhone">Work Phone: </label><input name="workPhone" type="text" value="{$wp}" />
	<br /><br />
	<label for="cellPhone">Cell Phone: </label><input name="cellPhone" type="text" value="{$cp}" />
</fieldset>
<br /><br />

<fieldset onload="return initialize_registration_payment_options()">

	<legend>League Memberships</legend>

	<dl>
		<dt>TCSHL</dt>
		     <dd>- Tri-City Senior Hockey League</dd>		
		<dt>D.R.I.L.</dt>
		     <dd>- Developmental Recreational Introduction to Hockey League</dd>
	</dl>

	<input name="drilLeague" type="radio" value="1" {$dl1} onclick="return update_registration_payment_options()" /><label for="noDrilLeague">I want to play in the TCSHL only.</label>

	<br /><br />

	<input name="drilLeague" type="radio" value="2" {$dl2} onclick="return update_registration_payment_options()" /><label for="justDrilLeague">I want to play in D.R.I.L. only.</label>

	<br /><br />

	<input name="drilLeague" type="radio" value="3" {$dl3} onclick="return update_registration_payment_options()" /><label for="bothLeagues">I want to play in both D.R.I.L. and the TCSHL!</label>

</fieldset>

<br /><br />

<fieldset>

	<legend>Position</legend>

	<ul>
	    <li>Goalie Discount Price is only available for those players with ALL goalie gear planning on playing goalie only position.  Goalie positions are limited by numbers of teams drafted. Discount is not guaranteed for all signing up as Goalie only players.</li>
	</ul>

	<input name="position" type="radio" value="Goalie" {$gl} /><label for="goalie">Goalie </label>

	<input name="position" type="radio" value="Defense" {$df} /><label for="defense">Defense </label>

	<input name="position" type="radio" value="Forward" {$fw} /><label for="forward">Forward </label>

</fieldset>

<!--
<fieldset>
	<legend>Positions (Check All That Apply)</legend>
	<input name="goalie" type="checkbox" {$gl} /><label for="goalie">Goalie </label>
	<input name="defense" type="checkbox" {$df} /><label for="defense">Defense </label>
	<input name="center" type="checkbox" {$cr} /><label for="center">Center </label>
	<input name="wing" type="checkbox" {$wg} /><label for="wing">Wing </label>
</fieldset>-->
<br /><br />
<fieldset>
	<legend>Jersey Information</legend>
	<ul>
	    <li>Select jersey size.</li>
	    <li>A jersey number will be selected for you.</li>
	</ul>

	<input name="jerseySize" type="radio" value="L" {$jsl} /><label for="largeSize">L </label>
	<input name="jerseySize" type="radio" value="XL" {$jsxl} /><label for="xLargeSize">XL </label>
	<input name="jerseySize" type="radio" value="XXL" {$jsxxl} /><label for="xxLargeSize">XXL </label>
	<input name="jerseySize" type="radio" value="GOALIE" {$jsgoalie} /><label for="goalieSize">Goalie </label>
	<br /><br />
	<input name="jerseyNumChoiceOne" type="hidden" value="1" />

	<input name="jerseyNumChoiceTwo" type="hidden" value="2" />

	<input name="jerseyNumChoiceThree" type="hidden" value="3" />

<!--
	Jersey Number (Choose three numbers, between 0-99, with choice number 1 being the number you would most like to have.)
	<br />
	<label for="jerseyNumChoiceOne">Choice 1: </label><input name="jerseyNumChoiceOne" type="text" value="{$j1}" />
	<label for="jerseyNumChoiceTwo">Choice 2: </label><input name="jerseyNumChoiceTwo" type="text" value="{$j2}" />
	<label for="jerseyNumChoiceThree">Choice 3: </label><input name="jerseyNumChoiceThree" type="text" value="{$j3}" />		
	-->
</fieldset>
<br /><br />
<fieldset>
	<legend>Skill Level</legend>
	<input name="skillLevel" type="radio" value="1" {$sl1} /><label for="beginnerSkill">Beginner (Less than 1 year experience, new skating, stick, etc skills)</label>
	<br /><br />
	<input name="skillLevel" type="radio" value="2" {$sl2} /><label for="level1Skill">Level 1 (Decent forward skating, lower backward skate & stick skills, grasp of game)</label>
	<br /><br />
	<input name="skillLevel" type="radio" value="3" {$sl3} /><label for="level2Skill">Level 2 (Good forward movement, decent backward, good all around medium skill)</label>
	<br /><br />
	<input name="skillLevel" type="radio" value="4" {$sl4} /><label for="level3Skill">Level 3 (Front/back skating proficient, good skills but can't move puck end to end alone)</label>
	<br /><br />
	<input name="skillLevel" type="radio" value="5" {$sl5} /><label for="level4Skill">Level 4 (All skating, shooting, passing skills available, extensive playing background)</label>
</fieldset>
<br /><br />
<fieldset>
	<legend>Will you sub for other teams? (If yes, select best night(s).)</legend>
	<input name="willSub" type="radio" value="Y" {$ys} /><label for="yesSub">Yes</label>
	<input name="willSub" type="radio" value="N" {$ns} /><label for="noSub">No</label>
	<br /><br />
	<input name="sunSub" type="checkbox" {$su} /><label for="sunSub">Sunday </label>
	<input name="monSub" type="checkbox" {$sm} /><label for="monSub">Monday </label>
	<input name="tueSub" type="checkbox" {$st} /><label for="tueSub">Tuesday </label>
	<input name="wedSub" type="checkbox" {$sw} /><label for="wedSub">Wednesday </label>
	<input name="thuSub" type="checkbox" {$sh} /><label for="thuSub">Thursday </label>
	<input name="friSub" type="checkbox" {$sf} /><label for="friSub">Friday </label>
	<input name="satSub" type="checkbox" {$ss} /><label for="satSub">Saturday </label>	
</fieldset>
<br /><br />
<fieldset>
	<legend>If you will be traveling and will be doing so with other player(s), list them here:</legend>
	<input name="travelWith" type="text" value="{$tw}" />
</fieldset>
<br /><br />
<fieldset>
	<legend>Miscellaneous</legend>
	Are you interested in being a Team Rep?
	<input name="teamRep" type="radio" value="Y" {$yr}/><label for="yesTeamRep">Yes</label>
	<input name="teamRep" type="radio" value="N" {$nt} /><label for="noTeamRep">No</label>
	<br /><br />
	Are you interested in being a referee?
	<input name="referee" type="radio" value="Y" {$wr}/><label for="yesReferee">Yes</label>
	<input name="referee" type="radio" value="N" {$nr} /><label for="noReferee">No</label>	
</fieldset>
<br /><br /><fieldset>
	<legend>Payment Option</legend>
	
	<ul>
		<li>Late Registration Fee (After League Draft Day): $100, (New TCSHL members are exempt)</li>
		<li>Refunds:  All refunds must be reviewed and approved by the TCSHL Board.</li>
		<li>Referees will be expected to pay half of member fees at beginning of season.</li>
		<li>A $25.00 fee will be added to all payment plans with more than 1 installment.</li>
		<!-- <li>Payment types include cash, check or credit card.</li> -->
	</ul>
	<input name="paymentPlan" type="radio" value="5" {$p5} onclick="return update_registration_payment_options()" />DRIL Only Payment Plan. TOTAL = $120

	<br /><br />
	
	<input name="paymentPlan" type="radio" value="1" {$p1} onclick="return update_registration_payment_options()" />Plan I - 1 Installment.  One payment of $350 in full on or before League Draft Day.  TOTAL = $350*
	<br /><br />
	<input name="paymentPlan" type="radio" value="2" {$p2} onclick="return update_registration_payment_options()" />Plan II - 2 Installments.  Two payments of $187.50.   First payment due on or before League Draft Day.   Second payment due by Dec 15th.  TOTAL = $375*
	<br /><br />
	<input name="paymentPlan" type="radio" value="3" {$p3} onclick="return update_registration_payment_options()" />Plan III - 3 Installments.  Three payments of $125.  First payment is due on or before League Draft Day.  Second payment due by Nov 15th.  Third payment due by Jan 15th.  TOTAL = $375*
	<br /><br />

	<input name="paymentPlan" type="radio" value="4" {$p4} onclick="return update_registration_payment_options()" />Plan IV - 4 Installments.  Four payments of $93.75.  First payment is due on or before League Draft Day.  Second payment due by Oct 31st.  Third payment due by Dec 15th.  Fourth payment due by Feb 1st.  TOTAL = $375*
	
	<br /><br />
	* - Add $120 to this total if playing in DRIL.

</fieldset>
<br /><br />

<fieldset>

	<legend>Pay Today</legend>
	
	<ul>
	  <li>Pay today via credit card or paypal, click the box below and you will be taken to a payment page immediatley following registration.</li>
	  <li>If you chose an installment plan, your first payment will be today and all remaining payments will need to be paid on or before their due date.</li>
	</ul>

	<input name="payToday" type="checkbox" {$pt} /><label for="payToday">Pay Today </label>
	

</fieldset>

<br /><br />

<fieldset>
	<legend>Additional Notes</legend>
	<textarea cols="30" rows="3" name="additionalNotes">{$an}</textarea>
</fieldset>
<br />
{if $type == 'EDIT'}
	<input name="action" type="submit" value="Edit Registration" />
{else}
	<input name="action" type="submit" value="Register" />
{/if}
	</form>
