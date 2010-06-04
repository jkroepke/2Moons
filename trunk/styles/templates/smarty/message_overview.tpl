{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
<table width="60%" align="center">
<tr>
<td class="c" colspan="11">{$mg_overview}
</td>
</tr>
<tr>
{foreach name=MessageList key=MessID item=MessInfo from=$MessageList}
<th style="width:{100 / $smarty.foreach.MessageList.total}%;"><a href="javascript:ajax('game.php?page=messages&amp;mode=show&amp;messcat={$MessID}','frame');" onclick="$('#unread_{$MessID}').text('0');" style="color:{$MessInfo.color};">{$MessInfo.lang}</a>
{/foreach}
</tr>
<tr>
{foreach key=MessID item=MessInfo from=$MessageList}
<th style="color:{$MessInfo.color};"><span id="unread_{$MessID}">{$MessInfo.unread}</span>/{$MessInfo.total}</th>
{/foreach}
</tr>
<tr>
<td colspan="11" id="frame" style="margin:0px;padding:0px !important;">
</td>
</tr>
<tr>
<td colspan="11" class="c">{$mg_game_operators}</td>
</tr>
{foreach item=OpsInfo from=$OpsList}
<tr>
<th colspan="11">{$OpsInfo.username}<a href="mailto:{$OpsInfo.email}" title="Schreibe eine Mail an {$OpsInfo.username}"><img src="{$dpath}img/m.gif" alt="Schreibe eine Mail an {$OpsInfo.username}"></a></th>
</tr>
{/foreach}
</table>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}