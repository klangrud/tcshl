{if $announcements}
<br />
<div id="publicIndexAnnouncements">
	<span class="indexSubTitle">Announcements</span>
	<hr />
	{section name=announcement loop=$announcementId}
	<div class="publicIndexAnnouncementsTitle">
		{$announcementTitle[announcement]} <span class="globalFormToggle"><a id="js_announcement_{$announcementId[announcement]}" href="javascript:toggleObjectForm('div_announcement_{$announcementId[announcement]}','js_announcement_{$announcementId[announcement]}','view','close');">view</a></span>
	</div>
	<div id="div_announcement_{$announcementId[announcement]}" style="display: none">
		<div class="publicIndexAnnouncementsBody">
			{$announcementBody[announcement]}
		</div>
		<div class="publicIndexAnnouncementsUser">
			{$userSubmitted[announcement]}
		</div>		
	</div>
	<br />
	{/section}
</div>
{/if}
