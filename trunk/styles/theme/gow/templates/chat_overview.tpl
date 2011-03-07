{include file="overall_header.tpl"}
{if !$ctype}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
{/if}
<iframe src="./chat/?chat_type={$ctype}" style="border: 0px;width:100%;height:800px;"></iframe>
{if !$ctype}
</div>
{include file="planet_menu.tpl"}
{/if}
{include file="overall_footer.tpl"}