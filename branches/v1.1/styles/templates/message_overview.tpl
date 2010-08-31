{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
<table >
<tr>
<th colspan="11">{$mg_overview}</th>
</tr>
<tr>
{foreach name=MessageList key=MessID item=MessInfo from=$MessageList}
<td style="width:{100 / $smarty.foreach.MessageList.total}%;"><a href="javascript:ajax('game.php?page=messages&amp;mode=show&amp;messcat={$MessID}','frame');" onclick="messages({$MessID});" style="color:{$MessInfo.color};">{$MessInfo.lang}</a></td>
{/foreach}
</tr>
<tr>
{foreach key=MessID item=MessInfo from=$MessageList}
<td style="color:{$MessInfo.color};"><span id="unread_{$MessID}">{$MessInfo.unread}</span>/{$MessInfo.total}</td>
{/foreach}
</tr>
<tr>
<td class="tranparent" colspan="11" id="frame" style="margin:0px;padding:0px !important;">
</td>
</tr>
<tr>
<th colspan="11">{$mg_game_operators}</th>
</tr>
{foreach item=OpsInfo from=$OpsList}
<tr>
<td colspan="11">{$OpsInfo.username}<a href="mailto:{$OpsInfo.email}" title="Schreibe eine Mail an {$OpsInfo.username}"><img src="{$dpath}img/m.gif" alt="Schreibe eine Mail an {$OpsInfo.username}"></a></td>
</tr>
{/foreach}
</table>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}