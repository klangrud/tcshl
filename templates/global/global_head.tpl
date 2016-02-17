<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
<head>
{include file="global/includes/inc_title.tpl"}
{include file="global/includes/inc_meta.tpl"}
{include file="global/includes/inc_css.tpl"}
{include file="global/includes/inc_javascript.tpl"}
</head>

<body{if $environment == 'dev'} id="devBody"{elseif $environment == 'stage'} id="stageBody"{/if}>

<!-- This is the global container.  This begins right after the body tag.  And ends before the closing body tag. -->
<div id="globalBody">

{include file="global/includes/inc_user_status.tpl"}

{include file="global/includes/inc_main_banner.tpl"}

{include file="global/includes/inc_main_menu.tpl"}

{include file="global/includes/inc_marquee.tpl"}
