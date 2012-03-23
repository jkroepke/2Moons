{include file="main.header.tpl" bodyclass="full"}
{if $hasAdminAccess}
<div class="globalWarning">
{$LNG.admin_access_1} <a id="drop-admin">{$LNG.admin_access_link}</a>{$LNG.admin_access_2}
</div>
{/if}
{include file="main.navigation.tpl"}
{include file="main.topnav.tpl"}
<div id="content">{block name="content"}{/block}</div>
{include file="main.footer.tpl" nocache}