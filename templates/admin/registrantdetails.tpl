<h1>{$fname} {$lname}'s Details</h1>
<a href="editregistration.php?id={$registrationId}">edit registration</a>
<br /><br />
<div id="{$skillDivId}">Skill Level: {$skillLevel};    Position{if strlen($position) > 1}s{/if}: {$position} </div>

<b>Season:</b> {$seasonId}
<br />
<b>Registration Id:</b> {$registrationId}
<br />
<b>Player Id:</b> {if $playerId}{$playerId}{if $playerName} - {$playerName}{/if}{else}Assigned when registration is approved.{/if}
<br /><br />
<b>Name:</b> {$fname} {$lname}
<br />
<b>Address:</b> {$address}
<br />
<b>Email:</b> {$email}
<br />
<b>Home Phone:</b> {$homePhone}
<br />
<b>Work Phone:</b> {$workPhone}
<br />
<b>Cell Phone:</b> {$cellPhone}
<br /><br />
<b>USA Hockey Membership:</b>
{if $usaHockeyMembership == "NONE"}
  <font class="globalRed">NOT a USA Hockey member</font>
{else}
  <a href="https://www.usahockeyregistration.com/show_confirmation.action?confirmation={$usaHockeyMembership}">https://www.usahockeyregistration.com/show_confirmation.action?confirmation={$usaHockeyMembership}</a>
{/if}
<br />
<b>League Membership:</b> {if $drilLeague == "1"}TCSHL Only{elseif $drilLeague == "2"}D.R.I.L. Only{else}Both TCSHL and D.R.I.L.{/if}
<br /><br />
<b>Skill Level:</b> {$skillLevel}
<br />
<b>Position{if strlen($position) > 1}s{/if}:</b> {$position}
<br /><br />
<b>Jersey Size:</b> {$jerseySize}
<br />
<b>Jersey Number Choice 1:</b> {$jerseyNumberOne}
<br />
<b>Jersey Number Choice 2:</b> {$jerseyNumberTwo}
<br />
<b>Jersey Number Choice 3:</b> {$jerseyNumberThree}
<br /><br />
<b>Wants to sub:</b> {if $wantToSub == "1"}YES{else}NO{/if}
<br />
{if $wantToSub == "1"}
<b>Days willing to sub:</b>
<br />
<table>
  <tr>
    <td>Sunday</td>
    <td>Monday</td>
    <td>Tuesday</td>
    <td>Wednesday</td>
    <td>Thursday</td>
    <td>Friday</td>
    <td>Saturday</td>
  </tr>
  <tr>
    <td>{if $subSunday == "1"}YES{else}NO{/if}</td>
    <td>{if $subMonday == "1"}YES{else}NO{/if}</td>
    <td>{if $subTuesday == "1"}YES{else}NO{/if}</td>
    <td>{if $subWednesday == "1"}YES{else}NO{/if}</td>
    <td>{if $subThursday == "1"}YES{else}NO{/if}</td>
    <td>{if $subFriday == "1"}YES{else}NO{/if}</td>
    <td>{if $subSaturday == "1"}YES{else}NO{/if}</td>
  </tr>
</table>
<br />
{/if}
<b>Traveling with:</b> {$travelingWithWho}
<br />
<b>Wants to be team rep:</b> {if $wantToBeATeamRep == "1"}YES{else}NO{/if}
<br />
<b>Wants to be a referee:</b> {if $wantToBeARef == "1"}YES{else}NO{/if}
<br />
<b>Opted to pay via CC or paypal:</b> {if $payToday == "1"}YES{else}NO{/if}
<br />
<b>Payment Option:</b> Plan {if $paymentPlan == "1"}I (1 Payment){elseif $paymentPlan == "2"}II (2 Payments){elseif $paymentPlan == "3"}III  (3 Payments){elseif $paymentPlan == "4"}IV  (4 Payments){else}None{/if}
<br />
<b>Registration Approved:</b> {if $registrationApproved == "1"}YES{else}NO. Would you like to approve this as a <a href="approveregistration.php?registrantid={$registrationId}"> new player registration</a> or a <a href="approveformerregistration.php?registrantid={$registrationId}">former player registration</a>?{/if}
<br />
<b>Additional Notes:</b> {$additionalNotes}
<br /><br />
