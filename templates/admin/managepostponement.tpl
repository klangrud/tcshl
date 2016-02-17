<h1>{$page_name}</h1>
<hr />
<b>{$guestTeam} vs. {$homeTeam}</b>
<br /><br />
<b>{$gameTime}</b>
<hr />

{if $rescheduleGame || $gamePostponed}
  {include file="admin/includes/inc_reschedule_form.tpl"}
{elseif $gameOn || $gamePastButNoScore}
  {include file="admin/includes/inc_postponement_form.tpl"}
{else}
  This game is not available for postponement.
{/if}

<hr />