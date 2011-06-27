{include file="overall_header.tpl"}
{if !$ctype}
{include file="left_menu.tpl"}
{include file="overall_topnav.tpl"}
<div id="content">
{/if}
<iframe src="./chat/?chat_type={$ctype}" style="border: 0px;width:100%;height:800px;" ALLOWTRANSPARENCY="true"></iframe>
{if !$ctype}
</div>
{include file="planet_menu.tpl"}
{/if}
{include file="overall_footer.tpl"}